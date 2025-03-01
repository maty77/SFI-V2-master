<?php
//conexion.php - Conexión centralizada

$host = 'localhost';            //Servidor
$user = 'root';                 //Usuario por defecto de XAMPP
$password = '';                 //Sin contraseña
$baseDeDatos = 'opticavision';  //Nombre BD

//Crear conexión usando MySLi moderno
$conexion = new mysqli($host, $user, $password,$baseDeDatos);

// Comprobar si hay error
if ($conexion->connect_error){
    die('Error de conexión a la base de datos: ' . $conexion->connect_error);
}

//Configurar el juego de caracteres (acentos y ñ)
$conexion->set_charset("utf8");
?>
