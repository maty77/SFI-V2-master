<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['fecha_desde']) && isset($_GET['fecha_hasta'])) {
    $fechaDesde = $_GET['fecha_desde'] . " 00:00:00";
    $fechaHasta = $_GET['fecha_hasta'] . " 23:59:59";

    $SQL = "SELECT 
               v.fecha, v.id_venta, v.total, u.DNI_U, fp.pago, te.entrega, SUM(v.total) AS totalventa
            FROM 
               venta v
            INNER JOIN 
               usuario u ON u.DNI_U = v.DNI_U
            INNER JOIN 
               tipopago fp ON v.id_pago = fp.id_pago
            INNER JOIN 
               tipoentrega te ON v.id_ent = te.id_ent
            WHERE 
               v.fecha BETWEEN ? AND ?
            GROUP BY 
               v.id_venta, v.fecha, u.DNI_U, fp.pago";

    $stmt = $MiConexion->prepare($SQL);
    $stmt->bind_param("ss", $fechaDesde, $fechaHasta);
    $stmt->execute();
    $result = $stmt->get_result();

    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=reporte_ventas.xls");

    echo "<?xml version=\"1.0\"?>\n";
    echo "<?mso-application progid=\"Excel.Sheet\"?>\n";
    echo "<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
          xmlns:o=\"urn:schemas-microsoft-com:office:office\"
          xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
          xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
          xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
    
    echo "<Worksheet ss:Name=\"ReporteVentas\">\n";
    echo "<Table>\n";

    echo "<Row>\n";
    echo "<Cell><Data ss:Type=\"String\">FECHA</Data></Cell>\n";
    echo "<Cell><Data ss:Type=\"String\">N° VENTA</Data></Cell>\n";
    echo "<Cell><Data ss:Type=\"String\">TOTAL VENTA</Data></Cell>\n";
    echo "<Cell><Data ss:Type=\"String\">VENDEDOR</Data></Cell>\n";
    echo "<Cell><Data ss:Type=\"String\">FORMA DE PAGO</Data></Cell>\n";
    echo "<Cell><Data ss:Type=\"String\">ENTREGA</Data></Cell>\n";
    echo "</Row>\n";

    $totalGeneral = 0;
    while ($row = $result->fetch_assoc()) {
        $totalGeneral += $row['totalventa'];
        echo "<Row>\n";
        echo "<Cell><Data ss:Type=\"String\">" . $row['fecha'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . $row['id_venta'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"Number\">" . $row['total'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . $row['DNI_U'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . $row['pago'] . "</Data></Cell>\n";
        echo "<Cell><Data ss:Type=\"String\">" . $row['entrega'] . "</Data></Cell>\n";
        echo "</Row>\n";
    }

    echo "<Row>\n";
    echo "<Cell><Data ss:Type=\"String\">Total General</Data></Cell>\n";
    echo "<Cell/>\n";
    echo "<Cell><Data ss:Type=\"Number\">" . $totalGeneral . "</Data></Cell>\n";
    echo "<Cell/><Cell/><Cell/>\n";
    echo "</Row>\n";

    echo "</Table>\n";
    echo "</Worksheet>\n";
    echo "</Workbook>\n";

} else {
    echo "Error: Fechas no especificadas.";
}
?>
