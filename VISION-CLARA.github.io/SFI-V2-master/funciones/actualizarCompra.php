<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensajeC = '';
    $mensajeE = '';

    // Obtener datos del formulario
    $proveedor = $_POST['proveedor'] ?? '';  
    $formaPago = $_POST['FPago'] ?? '';
    $fecha = $_POST['Fecha'] ?? '';
    $detallesCompra = isset($_POST['detallesCompra']) ? json_decode($_POST['detallesCompra'], true) : [];
    $nuevoID = $_POST['id_compra'] ?? null; 

    if (empty($nuevoID)) {
        $mensajeE = "Error: El campo 'ID de Compra' es requerido.<br>";
    }
    if (empty($proveedor)) {
        $mensajeE = "Error: El campo 'Proveedor' es requerido.<br>";
    }
    if (empty($formaPago)) {
        $mensajeE = "Error: El campo 'Forma de pago' es requerido.<br>";
    }
    if (empty($fecha)) {
        $mensajeE = "Error: El campo 'Fecha' es requerido.<br>";
    }
    if (empty($detallesCompra)) {
        $mensajeE = "Error: El campo 'Detalles de la compra' es requerido.<br>";
    }

    // Si algún campo está vacío, detener el proceso
    if (empty($nuevoID) || empty($proveedor) || empty($formaPago) || empty($fecha) || empty($detallesCompra)) {
        exit;  
    }

    $fechaFormateada = date('Y-m-d', strtotime($fecha));

    $MiConexion->begin_transaction();

    try {
        // Actualizar la compra en la tabla 'compra'
        $stmtCompra = $MiConexion->prepare("UPDATE compra SET id_proveedor = ?, id_pago = ?, fecha = ? WHERE id_compra = ?");
        $stmtCompra->bind_param("iisi", $proveedor, $formaPago, $fechaFormateada, $nuevoID);

        if (!$stmtCompra->execute()) {
            throw new Exception("Error al actualizar en la tabla 'compra': " . $stmtCompra->error);
        }

        // Eliminar los detalles existentes con el id_compra
        $stmtEliminarDetalles = $MiConexion->prepare("DELETE FROM detallecompra WHERE id_compra = ?");
        $stmtEliminarDetalles->bind_param("i", $nuevoID);

        if (!$stmtEliminarDetalles->execute()) {
            throw new Exception("Error al eliminar los registros existentes de detallecompra: " . $stmtEliminarDetalles->error);
        }

        // Insertar los nuevos detalles de la compra en la tabla 'detallecompra'
        $stmtDetalle = $MiConexion->prepare("INSERT INTO detallecompra (id_compra, id_prod, cantprod, totalcompra) VALUES (?, ?, ?, ?)");

        foreach ($detallesCompra as $detalle) {
            $idProducto = (int) $detalle['id_prod'];
            $cantidad = (int) $detalle['cantprod'];
            $total = (float) $detalle['totalcompra'];

            $stmtDetalle->bind_param("iiid", $nuevoID, $idProducto, $cantidad, $total);

            if (!$stmtDetalle->execute()) {
                // Si hay un error en la inserción, revertir la transacción
                throw new Exception("Error al insertar en la tabla 'detallecompra': " . $stmtDetalle->error);
            }
        }

        // Si todo está bien confirmar la transacción
        $MiConexion->commit();
        $mensajeC = "Compra y detalles actualizados con éxito.";

    } catch (Exception $e) {
        // Si algo sale mal revertir la transacción
        $MiConexion->rollback();
        $mensajeE = "Error al actualizar la compra: " . $e->getMessage();
    }
} else {
    // Si no se recibió una solicitud POST
    $mensaje = ".";
}
?>