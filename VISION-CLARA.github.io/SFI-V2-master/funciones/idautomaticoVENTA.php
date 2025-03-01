<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

$query = "SELECT MAX(id_venta) AS ultimo_id FROM venta"; 
$result = $MiConexion->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $ultimoID = $row['ultimo_id'] ? (int)$row['ultimo_id'] : 0;
} else {
    $ultimoID = 1; // Si no hay registros, empieza en 0
}

$nuevoID = $ultimoID + 1;
?>