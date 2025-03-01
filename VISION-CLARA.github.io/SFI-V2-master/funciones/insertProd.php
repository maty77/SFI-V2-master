<?php 
function InsertarProd($vConexion, $rutaImagen){
    $Dispo = !empty($_POST['Disponibilidad']) ? $_POST['Disponibilidad'] : '';
    $SQL_Insert = "INSERT INTO producto (ID_PROD, ID_PROVEEDOR, ID_MARCA, PRODUCTO, PRECIO_VENTA, PRECIO_COMPRA, IMAGEN, id_tipoprod, MODELO, MATERIAL, DESCRIPCION, Disponibilidad )
    VALUES (" . $_POST['Id_Prod'] . ", " . $_POST['Id_Prove'] . ", " . $_POST['Id_Marca'] . ", '" . $_POST['NombreProd'] . "', " . $_POST['Precio_V'] . ", " . $_POST['Precio_C'] . ", '" . $rutaImagen . "', " . $_POST['Id_tpprod'] . ", '" . $_POST['Modelo'] . "', '" . $_POST['Material'] . "', '" . $_POST['Descripcion'] . "', " . $Dispo . ")";
    
    if (!mysqli_query($vConexion, $SQL_Insert)) {
        return false;
    }
    return true;
}