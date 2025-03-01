<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCompra = intval($_GET['id']);

    // Consulta para obtener los datos de la compra
    $sql = "SELECT c.FECHA, pr.PROVEEDOR, p.PAGO, dc.TOTALCOMPRA 
    FROM compra c 
    INNER JOIN detallecompra dc ON c.ID_COMPRA=dc.ID_COMPRA
    INNER JOIN proveedor pr ON c.ID_PROVEEDOR=pr.ID_PROVEEDOR
    INNER JOIN tipopago p ON c.ID_PAGO=p.ID_PAGO
    WHERE c.ID_COMPRA = ?";
    $stmt = $MiConexion->prepare($sql);
    $stmt->bind_param("i", $idCompra);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $compra = $resultado->fetch_assoc();
    } else {
        die("No se encontró la compra con el ID especificado.");
    }

    // Consulta para obtener los productos del detalle de la compra
    $sqlProductos = "SELECT p.producto, dc.cantprod, p.precio_compra 
    FROM detallecompra dc
    INNER JOIN producto p ON p.id_prod = dc.id_prod
    WHERE dc.id_compra = ?";
    $stmtProductos = $MiConexion->prepare($sqlProductos);
    $stmtProductos->bind_param("i", $idCompra);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();

// Consulta para obtener la suma del totalventa
    $sqlTotalCompra = "SELECT SUM(totalcompra) AS total_suma FROM detallecompra WHERE id_compra = ?";
    $stmtTotalCompra = $MiConexion->prepare($sqlTotalCompra);
    $stmtTotalCompra->bind_param("i", $idCompra);
    $stmtTotalCompra->execute();
    $resultadoTotalCompra = $stmtTotalCompra->get_result();

    $totaldc = 0;
    if ($resultadoTotalCompra->num_rows > 0) {
        $rowTotal = $resultadoTotalCompra->fetch_assoc();
        $totaldc = $rowTotal['total_suma']; 
    
} else {
    echo "ID de compra no válido.";
    exit;
}

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Reporte_Compra_$idCompra.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table border='1'>";
    echo "<tr><th colspan='2'>Reporte de Compra</th></tr>";
    echo "<tr><th>ID Compra</th><td>{$idCompra}</td></tr>";
    echo "<tr><th>Fecha</th><td>{$compra['FECHA']}</td></tr>";
    echo "<tr><th>Proveedor</th><td>{$compra['PROVEEDOR']}</td></tr>";
    echo "<tr><th>Tipo de Pago</th><td>{$compra['PAGO']}</td></tr>";
    echo "<tr><th>Total pago</th><td>{$totaldc}</td></tr>";

    echo "<tr><th colspan='3'>Productos</th></tr>";
    echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Compra</th></tr>";

    while ($producto = $resultadoProductos->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$producto['producto']}</td>";
        echo "<td>{$producto['cantprod']}</td>";
        echo "<td>{$producto['precio_compra']}</td>";
        echo "</tr>";
    }

    echo "</table>";

    exit;
} else {
    echo "ID de compra no válido.";
    exit;
}
