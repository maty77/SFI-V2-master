<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

$totalGeneral = 0;
$result = null;

// Capturar valores de filtros desde GET
$fechaDesde = $_GET['fecha_desde'] ?? '';
$fechaHasta = $_GET['fecha_hasta'] ?? '';
$proveedor = $_GET['proveedor'] ?? '';
$formaPago = $_GET['forma_pago'] ?? '';

// Construcción de la consulta SQL con filtros dinámicos
$filtros = ["c.fecha BETWEEN ? AND ?"];
$parametros = [$fechaDesde, $fechaHasta];

if (!empty($proveedor)) {
    $filtros[] = "c.id_proveedor = ?";
    $parametros[] = $proveedor;
}

if (!empty($formaPago)) {
    $filtros[] = "c.id_pago = ?";
    $parametros[] = $formaPago;
}

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
            tipopago tp ON c.id_pago = tp.id_pago";

if (count($filtros) > 0) {
    $SQL .= " WHERE " . implode(" AND ", $filtros);
}

$SQL .= " GROUP BY c.id_compra, c.fecha, p.proveedor, tp.pago";

$stmt = $MiConexion->prepare($SQL);
$tipos = str_repeat("s", count($parametros));  // Ajustar si hay valores enteros
$stmt->bind_param($tipos, ...$parametros);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General de Compras</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <style>
        html {
            background-color: white;
        }
        body {
            font-family: monospace;
            margin: 20px;
            color: #0F0768;
            background-color: white;
        }
        .reporte {
            border: 1px solid #ccc;
            padding: 2px;
            border-radius: 5px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            overflow-x: auto;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            table-layout: fixed;
            word-wrap: break-word;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: normal;
            word-break: break-word;
        }
        th {
            text-align: center;
            background-color:#B1ACE3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <h4>Reporte de Compras del <?= htmlspecialchars($fechaDesde) ?> al <?= htmlspecialchars($fechaHasta) ?></h4>

    <table border="1">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Pago</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php $totalGeneral += $row['totalcompra']; ?>
                <tr>
                    <td><?= htmlspecialchars($row['fecha']); ?></td>
                    <td><?= htmlspecialchars($row['proveedor']); ?></td>
                    <td><?= htmlspecialchars($row['pago']); ?></td>
                    <td><?= number_format($row['totalcompra'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
            
            <tr class="total-row">
                <td colspan="3">Total General</td>
                <td><?= number_format($totalGeneral, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <br>
    <button onclick="window.print()" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">IMPRIMIR</button>
    <br><br>
    <a href="excel_gral_compra.php?fecha_desde=<?= htmlspecialchars($fechaDesde) ?>&fecha_hasta=<?= htmlspecialchars($fechaHasta) ?>&proveedor=<?= htmlspecialchars($proveedor) ?>&forma_pago=<?= htmlspecialchars($formaPago) ?>" 
       class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
       DESCARGAR EXCEL
    </a>

</body>
</html>
