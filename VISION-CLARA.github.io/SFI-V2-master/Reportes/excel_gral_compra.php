<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['fecha_desde']) && isset($_GET['fecha_hasta'])) {
    $fechaDesde = $_GET['fecha_desde'];
    $fechaHasta = $_GET['fecha_hasta'];

    $SQL = "SELECT 
                c.fecha, 
                p.proveedor, 
                tp.pago, 
                SUM(dc.totalcompra) AS totalcompra
            FROM 
                compra c
            INNER JOIN 
                detallecompra dc ON c.id_compra = dc.id_compra
            INNER JOIN 
                proveedor p ON c.id_proveedor = p.id_proveedor
            INNER JOIN 
                tipopago tp ON c.id_pago = tp.id_pago
            WHERE 
                c.fecha BETWEEN ? AND ?
            GROUP BY 
                c.id_compra, c.fecha, p.proveedor, tp.pago";

    $stmt = $MiConexion->prepare($SQL);
    $stmt->bind_param("ss", $fechaDesde, $fechaHasta);
    $stmt->execute();
    $result = $stmt->get_result();

    header("Content-Type: application/vnd.ms-excel");
$nombreArchivo = "reporte_compras_{$fechaDesde}_al_{$fechaHasta}.xls";
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "Fecha\tProveedor\tPago\tTotal\n";

    $totalGeneral = 0;

    while ($row = $result->fetch_assoc()) {
        $totalGeneral += $row['totalcompra'];
        echo "{$row['fecha']}\t{$row['proveedor']}\t{$row['pago']}\t" . number_format($row['totalcompra'], 2) . "\n";
    }

    echo "\t\tTotal General\t" . number_format($totalGeneral, 2) . "\n";
} else {
    echo "Error: Fechas no especificadas.";
}
?>
