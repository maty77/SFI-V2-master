<?php
function ListarProd($vConexion) {

    $Listado=array();

    $SQL = "SELECT p.Id_Prod, pro.Proveedor, m.Marca, p.Producto, p.Precio_venta, p.Precio_compra, p.Imagen, tp.tipoproducto_desc, p.Modelo, p.Material, p.Descripcion, p.Disponibilidad
    FROM producto p, proveedor pro, marca m, tipoproducto tp
    WHERE p.Id_Proveedor=pro.Id_Proveedor AND p.Id_Marca=m.Id_Marca AND p.Id_tipoprod=tp.Id_tipoprod
    ORDER BY id_prod ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDPROD'] = $data['Id_Prod'];
            $Listado[$i]['PROVEEDOR'] = $data['Proveedor'];
            $Listado[$i]['MARCA'] = $data['Marca'];
            $Listado[$i]['PRODUCTO'] = $data['Producto'];
            $Listado[$i]['PRECIOV'] = $data['Precio_venta'];
            $Listado[$i]['PRECIOC'] = $data['Precio_compra'];
            $Listado[$i]['IMG'] = $data['Imagen'];
            $Listado[$i]['TIPOPROD'] = $data['tipoproducto_desc'];
            $Listado[$i]['MODELO'] = $data['Modelo'];
            $Listado[$i]['MATERIAL'] = $data['Material'];
            $Listado[$i]['DESC'] = $data['Descripcion'];
            $Listado[$i]['DISPO_P'] = $data['Disponibilidad'];
          

            $i++;
    }


    return $Listado;

}




?>