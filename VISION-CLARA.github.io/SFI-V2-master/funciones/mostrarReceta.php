<?php 
function ListarReceta($vConexion) {
    $Listado = array();
    
    // Capturamos el valor del DNI si se envía por GET
    $buscarDNI = '';
    if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
        // Es importante sanitizar la entrada para evitar inyección SQL
        $buscarDNI = mysqli_real_escape_string($vConexion, $_GET['buscar']);
    }
    
    $SQL = "SELECT v.id_venta, r.id_receta,
         v.FECHA, 
         cli.DNI_CLI, 
         v.total, 
         pro.promo, 
         pro.valor_descuento, 
         cob.cobertura, 
         fp.pago, 
         en.entrega,
         c.tipo_cristal,
         GROUP_CONCAT(DISTINCT t.tipo_trat SEPARATOR ', ') AS tratamientos
    FROM venta v 
    INNER JOIN detalleventa dv ON v.id_venta = dv.id_venta
    INNER JOIN usuario u ON u.DNI_U = v.DNI_U
    INNER JOIN cliente cli ON cli.DNI_CLI = v.DNI_CLI
    INNER JOIN promociones pro ON pro.id_promo = v.id_promo
    INNER JOIN cobertura cob ON cob.id_cob = v.id_cob
    INNER JOIN tipopago fp ON v.id_pago = fp.id_pago
    INNER JOIN tipoentrega en ON en.id_ent = v.id_ent
    LEFT JOIN venta_receta rv ON v.id_venta = rv.id_venta
    LEFT JOIN Receta r ON rv.id_receta = r.id_receta
    LEFT JOIN Cristales c ON r.id_cristal = c.id_cristal
    LEFT JOIN receta_tratamientos rt ON r.id_receta = rt.id_receta
    LEFT JOIN tratamientos t ON rt.id_trat = t.id_trat
    WHERE 1=1";
    
    // Si se ingresó un DNI, se añade la condición al query
    if (!empty($buscarDNI)) {
        $SQL .= " AND cli.DNI_CLI = '$buscarDNI'";
    }
    
    $SQL .= " GROUP BY r.id_receta, c.id_cristal, rt.id_receta
              ORDER BY tratamientos ASC";
    
    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDREC'] = $data['id_receta'];
        $Listado[$i]['FECHA'] = $data['FECHA'];
        $Listado[$i]['DNICLI'] = $data['DNI_CLI'];
        $Listado[$i]['TOTAL_V'] = $data['total'];
        $Listado[$i]['PROMO'] = $data['promo'];
        $Listado[$i]['DESCUENTO'] = $data['valor_descuento'];
        $Listado[$i]['COB'] = $data['cobertura'];
        $Listado[$i]['T_PAGO'] = $data['pago'];
        $Listado[$i]['T_ENTREGA'] = $data['entrega'];
        $Listado[$i]['T_CRISTAL'] = $data['tipo_cristal'];
        $Listado[$i]['TRAT'] = $data['tratamientos'];
        $Listado[$i]['ID_VENTA'] = $data['id_venta'];
        $i++;
    }
    return $Listado;
}