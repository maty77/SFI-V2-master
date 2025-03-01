<?php
function ListarVenta($vConexion) {

    $Listado=array();

    $SQL = "SELECT 
               v.fecha, v.id_venta, u.DNI_U, fp.pago, te.entrega, v.total
            FROM 
                venta v
            INNER JOIN 
                detalleventa dv ON v.id_venta = dv.id_venta
            INNER JOIN 
                usuario u ON u.DNI_U = v.DNI_U
            INNER JOIN 
                tipopago fp ON v.id_pago = fp.id_pago
            INNER JOIN 
                tipoentrega te ON v.id_ent = te.id_ent
            GROUP BY 
                v.id_venta, v.fecha, u.DNI_U, fp.pago
                ORDER BY v.fecha ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_VENTA'] = $data['id_venta'];
            $Listado[$i]['FECHA'] = $data['fecha'];
            $Listado[$i]['USER'] = $data['DNI_U'];
            $Listado[$i]['TPAGO'] = $data['pago'];
            $Listado[$i]['ENTREGA'] = $data['entrega'];
            $Listado[$i]['TOTALV'] = $data['total'];


            $i++;
    }


    return $Listado;

}




?>