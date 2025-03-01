<?php 

function ModificarUser($vconexion, $datos) {
    $dni = $datos['DNI'];
    $nombre = $datos['NombreUser'];
    $apellido = $datos['ApellidoUser'];
    $domicilio = $datos['DomicilioUser'];
    $ciudad = $datos['CiudadUser'];
    $provincia = $datos['Provincia'];
    $contacto = $datos['ContactoUser'];
    $email = $datos['EmailUser'];
    $contra = $datos['ContraUser'];


$query = "UPDATE usuario SET NOMBRE = ?, APELLIDO = ?, DOMICILIO = ?, CIUDAD = ?, ID_PROV = ?, CONTACTO = ?, USUARIO = ? , CONTRASENA = ? WHERE DNI_U = ? ";
$stmt = mysqli_prepare($vconexion, $query);

if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($vconexion));
}

mysqli_stmt_bind_param($stmt, "ssssssssi", $nombre, $apellido, $domicilio, $ciudad, $provincia, $contacto, $email, $contra, $dni);
return mysqli_stmt_execute($stmt);
}