<?php
require_once 'conexion.php'; 

if (isset($_GET['marca'])) {
    $marca = $_GET['marca'];

    if (!isset($conexion)) {
        echo json_encode(['error' => 'Error: conexión no establecida']);
        exit;
    }
    $query = "SELECT p.id_prod, p.producto, p.MODELO 
    FROM producto p
    INNER JOIN marca m ON p.id_marca = m.id_marca
    WHERE m.marca = ? AND p.disponibilidad=1";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $marca);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        echo json_encode($productos);
    } else {
        echo json_encode(['error' => 'Error en la consulta SQL']);
    }
} else {
    echo json_encode(['error' => 'Parámetro "marca" no proporcionado']);
}
?>