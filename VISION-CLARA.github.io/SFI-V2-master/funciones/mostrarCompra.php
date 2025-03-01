<?php
function ListarCompra($vConexion) {

    $Listado=array();

    $SQL = "SELECT 
                c.id_compra,
                c.fecha, 
                p.proveedor, 
                tp.pago, 
                SUM(dc.totalcompra) AS totalcompra
            FROM 
                compra c
            INNER JOIN 
                detallecompra dc ON c.id_compra = dc.id_compra
            INNER JOIN 
                proveedor p ON c.id_proveedor = p.id_proveedor
            INNER JOIN 
                tipopago tp ON c.id_pago = tp.id_pago
            GROUP BY 
                c.id_compra, c.fecha, p.proveedor, tp.pago
                ORDER BY c.fecha ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_COMPRA'] = $data['id_compra'];
            $Listado[$i]['FECHA'] = $data['fecha'];
            $Listado[$i]['PROVE'] = $data['proveedor'];
            $Listado[$i]['TPAGO'] = $data['pago'];
            $Listado[$i]['TOTALC'] = $data['totalcompra'];


            $i++;
    }


    return $Listado;

}




?>