<?php 

function ModificarProd($vconexion, $datos) {
    $Id = $datos['id_prod'];
    $nombre = $datos['producto'];
    $preciov = $datos['precio_venta'];
    $precioc = $datos['precio_compra'];
     $rutaImagen = $datos['rutaImagen'] ?? ''; // Asegúrate de pasarla
    $modelo = $datos['modelo'];
    $material = $datos['material'];
    $descripcion = $datos['descripcion'];
    $proveedor = $datos ['Id_Prove'];
    $marca = $datos ['Id_Marca'];
    $tpprod = $datos ['Id_tpprod'];

$query = "UPDATE producto SET producto = ?,  precio_venta = ?, precio_compra = ?, imagen = ?, modelo = ?, material = ?, descripcion=?, Id_Proveedor=?, Id_Marca=?, id_tipoprod=? WHERE id_prod = ?";
$stmt = mysqli_prepare($vconexion, $query);

if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($vconexion));
}

mysqli_stmt_bind_param($stmt, "ssssssssssi", $nombre, $preciov, $precioc, $rutaImagen, $modelo, $material, $descripcion, $proveedor, $marca, $tpprod, $Id);
return mysqli_stmt_execute($stmt);
}