<?php
require_once 'conexion.php';
$MiConexion = ConexionBD(); 

$mensajeE = '';
$mensajeC = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $proveedor = $_POST['proveedor'] ?? '';
    $formaPago = $_POST['FPago'] ?? '';
    $fecha = $_POST['Fecha'] ?? '';
    $detallesCompra = isset($_POST['detallesCompra']) ? json_decode($_POST['detallesCompra'], true) : [];
    $nuevoID = $_POST['id_compra'] ?? null;

    // Validación de campos
    if (empty($nuevoID) || empty($proveedor) || empty($formaPago) || empty($fecha) || empty($detallesCompra)) {
        exit("Error: Faltan datos en el formulario.");
    }

    // Formatear la fecha
    $fechaFormateada = date('Y-m-d', strtotime($fecha));

    // Iniciar una transacción
    $MiConexion->begin_transaction();

    try {
        // Eliminar los detalles existentes con el id_compra
        $stmtEliminarDetalles = $MiConexion->prepare("DELETE FROM detallecompra WHERE id_compra = ?");
        $stmtEliminarDetalles->bind_param("i", $nuevoID);
        if (!$stmtEliminarDetalles->execute()) {
            throw new Exception("Error al eliminar registros existentes de detallecompra: " . $stmtEliminarDetalles->error);
        }

        // Insertar la compra en la tabla 'compra'
        $stmtCompra = $MiConexion->prepare("INSERT INTO compra (id_compra, id_proveedor, id_pago, fecha) VALUES (?, ?, ?, ?)");
        $stmtCompra->bind_param("iiis", $nuevoID, $proveedor, $formaPago, $fechaFormateada);
        if (!$stmtCompra->execute()) {
            throw new Exception("Error al insertar en 'compra': " . $stmtCompra->error);
        }

        // Insertar los detalles de la compra y actualizar el inventario
        $stmtDetalle = $MiConexion->prepare("INSERT INTO detallecompra (id_compra, id_prod, cantprod, totalcompra) VALUES (?, ?, ?, ?)");
        
        foreach ($detallesCompra as $detalle) {
            $idProducto = (int) $detalle['id_prod'];
            $cantidad = (int) $detalle['cantprod'];
            $total = (float) $detalle['totalcompra'];

            // Insertar en detallecompra
            $stmtDetalle->bind_param("iiid", $nuevoID, $idProducto, $cantidad, $total);
            if (!$stmtDetalle->execute()) {
                throw new Exception("Error al insertar en 'detallecompra': " . $stmtDetalle->error);
            }

            // Verificar si el producto ya existe en Inventario
            $queryCheckInventario = "SELECT * FROM Inventario WHERE id_prod = ?";
            $stmtCheckInventario = $MiConexion->prepare($queryCheckInventario);
            $stmtCheckInventario->bind_param("i", $idProducto);
            $stmtCheckInventario->execute();
            $resultInventario = $stmtCheckInventario->get_result();

            if ($resultInventario->num_rows > 0) {
                // Si existe, actualizar la cantidad de compras y calcular el nuevo stock
                $queryUpdateInventario = "UPDATE Inventario SET cantidad_c = cantidad_c + ? WHERE id_prod = ?";
                $stmtUpdateInventario = $MiConexion->prepare($queryUpdateInventario);
                $stmtUpdateInventario->bind_param("ii", $cantidad, $idProducto);
                if (!$stmtUpdateInventario->execute()) {
                    throw new Exception("Error al actualizar inventario: " . $stmtUpdateInventario->error);
                }
            } else {
                // Si no existe, insertar el producto con cantidad_v = 0 y calcular stock
                $queryInsertInventario = "INSERT INTO Inventario (id_prod, cantidad_v, cantidad_c) VALUES (?, 0, ?)";
                $stmtInsertInventario = $MiConexion->prepare($queryInsertInventario);
                $stmtInsertInventario->bind_param("ii", $idProducto, $cantidad);
                if (!$stmtInsertInventario->execute()) {
                    throw new Exception("Error al insertar en inventario: " . $stmtInsertInventario->error);
                }
            }
        }

        // Confirmar la transacción si todo está bien
        $MiConexion->commit();
       $mensajeC = "Compra y detalles registrados con éxito.";

    } catch (Exception $e) {
        // Si algo sale mal, revertir la transacción
        $MiConexion->rollback();
        $mensajeE = "Error al registrar la compra: " . $e->getMessage();
    }
}

// Mostrar el mensaje solo si no está vacío
if (!empty($mensaje)) {
    echo "<p>$mensaje</p>";
}
?>