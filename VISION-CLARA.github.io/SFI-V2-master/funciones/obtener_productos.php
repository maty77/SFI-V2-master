<?php
require_once 'conexion.php';

$MiConexion = ConexionBD();

$proveedor = $_GET['proveedor'];

$query = "SELECT p.id_prod, p.producto, p.MODELO, p.precio_compra FROM producto p INNER JOIN proveedor pr ON pr.id_proveedor=p.id_proveedor WHERE p.id_proveedor = ?";
$stmt = $MiConexion->prepare($query);
$stmt->bind_param("i", $proveedor);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
?>