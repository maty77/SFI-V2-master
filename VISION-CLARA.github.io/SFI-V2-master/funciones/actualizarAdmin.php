<?php 

function ModificarAdmin($vconexion, $datos) {
    $dni = $datos['DNI'];
    $nombre = $datos['NombreAdmin'];
    $apellido = $datos['ApellidoAdmin'];
    $domicilio = $datos['DomicilioAdmin'];
    $ciudad = $datos['CiudadAdmin'];
    $provincia = $datos['Provincia'];
    $contacto = $datos['ContactoAdmin'];
    $email = $datos['EmailAdmin'];
    $contra = $datos['ContraAdmin'];
    $jer = $datos['Jer'];

$query = "UPDATE usuario SET NOMBRE = ?, APELLIDO = ?, DOMICILIO = ?, CIUDAD = ?, ID_PROV = ?, CONTACTO = ?, USUARIO = ? , CONTRASENA = ?, ID_JER = ?  WHERE DNI_U = ? ";
$stmt = mysqli_prepare($vconexion, $query);

if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($vconexion));
}

mysqli_stmt_bind_param($stmt, "sssssssssi", $nombre, $apellido, $domicilio, $ciudad, $provincia, $contacto, $email, $contra, $jer, $dni);
return mysqli_stmt_execute($stmt);
}