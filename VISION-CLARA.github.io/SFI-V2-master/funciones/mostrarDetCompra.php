<?php
function ListarDC($vConexion) {

    $Listado=array();

    $SQL = "SELECT p.producto, p.modelo, m.marca, dc.id_prod, SUM(dc.cantprod) as CANT, p.precio_compra, p.precio_venta
            FROM detallecompra dc, producto p, marca m        
            WHERE dc.id_prod=p.id_prod AND p.id_marca=m.id_marca 
            GROUP BY dc.id_prod";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['PROD'] = $data['producto'];
            $Listado[$i]['MODELO'] = $data['modelo'];
            $Listado[$i]['MARCA'] = $data['marca'];
            $Listado[$i]['IDPROD'] = $data['id_prod'];
            $Listado[$i]['CANTPROD'] = $data['CANT'];
            $Listado[$i]['PRECIOC'] = $data['precio_compra'];
            $Listado[$i]['PRECIOV'] = $data['precio_venta'];


            $i++;
    }


    return $Listado;

}




?>