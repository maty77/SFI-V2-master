<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

if (isset($_POST['codigoProducto'])) {
    $codigoProducto = $_POST['codigoProducto'];

    $query = "SELECT p.id_prod, p.producto, p.modelo, m.marca, p.precio_venta, i.cantidad_c, i.cantidad_v, p.id_tipoprod, p.Disponibilidad
              FROM producto p
              INNER JOIN marca m ON m.id_marca = p.id_marca
              INNER JOIN inventario i ON i.id_prod = p.id_prod
              WHERE p.id_prod = ?";
    $stmt = $MiConexion->prepare($query);
    $stmt->bind_param("i", $codigoProducto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($producto = $resultado->fetch_assoc()) {

        $stock = $producto['cantidad_c'] - $producto['cantidad_v'];

        // Usamos el mismo nombre de campo que se seleccionó en la consulta (Disponibilidad)
        if ($producto['Disponibilidad'] == 0) {
            echo json_encode(['error' => 'Producto no disponible']);
        } else {
            if ($stock <= 0) {
                echo json_encode(['error' => 'No se puede agregar el producto. Stock insuficiente.']);
            } else {
                echo json_encode($producto);
            }
        }
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Código de producto no proporcionado']);
}
?>