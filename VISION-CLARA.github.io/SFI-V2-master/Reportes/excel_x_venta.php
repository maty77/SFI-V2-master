<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idVenta = intval($_GET['id']);

    // Consulta para obtener los datos de la venta
    $sqlVenta = "SELECT v.FECHA, u.DNI_U, cli.DNI_CLI, v.total, pro.promo, pro.valor_descuento, cob.cobertura, fp.pago, en.entrega 
                 FROM venta v 
                 INNER JOIN detalleventa dv ON v.id_venta = dv.id_venta
                 INNER JOIN usuario u ON u.DNI_U = v.DNI_U
                 INNER JOIN cliente cli ON cli.DNI_CLI = v.DNI_CLI
                 INNER JOIN promociones pro ON pro.id_promo = v.id_promo
                 INNER JOIN cobertura cob ON cob.id_cob = v.id_cob
                 INNER JOIN tipopago fp ON v.id_pago = fp.id_pago
                 INNER JOIN tipoentrega en ON en.id_ent = v.id_ent
                 WHERE v.id_venta = ?";
    $stmtVenta = $MiConexion->prepare($sqlVenta);
    $stmtVenta->bind_param("i", $idVenta);
    $stmtVenta->execute();
    $resultadoVenta = $stmtVenta->get_result();

    if ($resultadoVenta->num_rows > 0) {
        $venta = $resultadoVenta->fetch_assoc();
    } else {
        echo "No se encontró la venta con el ID especificado.";
    }

    // Consulta para obtener los productos del detalle de la venta
    $sqlProductos = "SELECT dv.id_prod, dv.cantprod, dv.totalventa, p.producto
                     FROM detalleventa dv
                     INNER JOIN producto p ON p.id_prod = dv.id_prod
                     WHERE dv.id_venta = ?";
    $stmtProductos = $MiConexion->prepare($sqlProductos);
    $stmtProductos->bind_param("i", $idVenta);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();

    // Crear un array para almacenar los datos de los productos
    $productos = [];
    while ($producto = $resultadoProductos->fetch_assoc()) {
        $productos[] = $producto['producto'] . " (Cant: " . $producto['cantprod'] . ")";
    }

    // Consulta para obtener la suma total de los productos de la venta
    $sqlTotalVenta = "SELECT SUM(totalventa) AS total_suma FROM detalleventa WHERE id_venta = ?";
    $stmtTotalVenta = $MiConexion->prepare($sqlTotalVenta);
    $stmtTotalVenta->bind_param("i", $idVenta);
    $stmtTotalVenta->execute();
    $resultadoTotalVenta = $stmtTotalVenta->get_result();

    $totaldv = 0;
    if ($resultadoTotalVenta->num_rows > 0) {
        $rowTotal = $resultadoTotalVenta->fetch_assoc();
        $totaldv = $rowTotal['total_suma'];
    }
} else {
    echo "ID de venta no válido.";
    exit;
}

$fecha      = $venta['FECHA'];
$DNI_U      = $venta['DNI_U'];
$DNI_CLI    = $venta['DNI_CLI'];
$totalventa = $venta['total'];
$promo      = $venta['promo'];
$descuento  = $venta['valor_descuento'];
$cobertura  = $venta['cobertura'];
$pago       = $venta['pago'];
$entrega    = $venta['entrega'];

$productos_str = implode(", ", $productos);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_venta_{$idVenta}.xls");

echo "<?xml version=\"1.0\"?>\n";
echo "<?mso-application progid=\"Excel.Sheet\"?>\n";
echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
       xmlns:o=\"urn:schemas-microsoft-com:office:office\"
       xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
       xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
       xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";

echo "<Worksheet ss:Name=\"ReporteVenta\">\n";
echo "<Table>\n";

echo "<Row>\n";
echo "<Cell ss:MergeAcross=\"1\"><Data ss:Type=\"String\">Reporte de Venta - ID: " . htmlspecialchars($idVenta) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Fecha</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($fecha) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Vendedor</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($DNI_U) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Cliente</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($DNI_CLI) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Productos</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($productos_str) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Total productos</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"Number\">" . $totaldv . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Promoción</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($promo) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Descuento</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($descuento . '%') . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">TOTAL VENTA</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"Number\">" . $totalventa . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Cobertura médica</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($cobertura) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Forma de pago</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($pago) . "</Data></Cell>\n";
echo "</Row>\n";

echo "<Row>\n";
echo "<Cell><Data ss:Type=\"String\">Forma de entrega</Data></Cell>\n";
echo "<Cell><Data ss:Type=\"String\">" . htmlspecialchars($entrega) . "</Data></Cell>\n";
echo "</Row>\n";

echo "</Table>\n";
echo "</Worksheet>\n";
echo "</Workbook>\n";
?>