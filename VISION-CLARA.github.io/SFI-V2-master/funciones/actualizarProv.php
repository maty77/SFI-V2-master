<?php 

function ModificarProveedor($vconexion, $datos) {
    $Id = $datos['Id_prove'];
    $nombre = $datos['Proveedor'];
    $domicilio = $datos['DomicilioProv'];
    $ciudad = $datos['CiudadProv'];
    $provincia = $datos['Provincia'];
    $contacto = $datos['ContactoProv'];
    $email = $datos['EmailProv'];

$query = "UPDATE proveedor SET PROVEEDOR = ?, DOMICILIO = ?, CIUDAD = ?, ID_PROV = ?, CONTACTO = ?, Email = ? WHERE ID_PROVEEDOR = ?";
$stmt = mysqli_prepare($vconexion, $query);

if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($vconexion));
}

mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $domicilio, $ciudad, $provincia, $contacto, $email, $Id);
return mysqli_stmt_execute($stmt);
}