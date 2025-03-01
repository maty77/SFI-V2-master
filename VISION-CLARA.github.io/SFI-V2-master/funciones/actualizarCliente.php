<?php 

function ModificarCliente($vconexion, $datos) {
    $dni = $datos['DNI'];
    $nombre = $datos['NombreCli'];
    $apellido = $datos['ApellidoCli'];
    $domicilio = $datos['DomicilioCli'];
    $ciudad = $datos['CiudadCli'];
    $provincia = $datos['Provincia'];
    $contacto = $datos['ContactoCli'];
    $email = $datos['EmailCli'];

$query = "UPDATE cliente SET NOMBRE = ?, APELLIDO = ?, DOMICILIO = ?, CIUDAD = ?, ID_PROV = ?, CONTACTO = ?, Email = ? WHERE DNI_CLI = ?";
$stmt = mysqli_prepare($vconexion, $query);

if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($vconexion));
}

mysqli_stmt_bind_param($stmt, "sssssssi", $nombre, $apellido, $domicilio, $ciudad, $provincia, $contacto, $email, $dni);
return mysqli_stmt_execute($stmt);
}