<?php 
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idCompra = intval($_GET['id']);

    //Consulta para obtener los datos de la compra
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
        echo "No se encontró la compra con el ID especificado.";
        exit;
    }
    //Consulta para obtener los productos del detalle de la compra
    $sqlProductos = "SELECT dc.id_prod, dc.cantprod, dc.totalcompra, p.producto, p.precio_compra
    FROM detallecompra dc
    INNER JOIN producto p ON p.id_prod = dc.id_prod
    WHERE dc.id_compra = ?";
    $stmtProductos = $MiConexion->prepare($sqlProductos);
    $stmtProductos->bind_param("i", $idCompra);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();

    $productos = [];
    while ($producto = $resultadoProductos->fetch_assoc()) {
        $productos[] = $producto['producto'] . " (Cant: " . $producto['cantprod'] . ")"." (Precio compra: " . $producto['precio_compra'] . " c/u) ";
    }

        //Consulta para obtener la suma del totalventa
    $sqlTotalCompra = "SELECT SUM(totalcompra) AS total_suma FROM detallecompra WHERE id_compra = ?";
    $stmtTotalCompra = $MiConexion->prepare($sqlTotalCompra);
    $stmtTotalCompra->bind_param("i", $idCompra);
    $stmtTotalCompra->execute();
    $resultadoTotalCompra = $stmtTotalCompra->get_result();

    $totaldc = 0;
    if ($resultadoTotalCompra->num_rows > 0) {
        $rowTotal = $resultadoTotalCompra->fetch_assoc();
        $totaldc = $rowTotal['total_suma']; 
    }
} else {
    echo "ID de compra no válido.";
    exit;
}

$fecha = $compra['FECHA'];
$proveedor = $compra['PROVEEDOR'];
$tipoPago = $compra['PAGO'];
$total = $compra['TOTALCOMPRA'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compra</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <style>
        html{
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
        table {
        table-layout: fixed;
        word-wrap: break-word;
        }

        h1, h2, h3 {
            text-align: left;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            white-space: normal;
            ord-break: break-word;
        }
        th {
            background-color:#B1ACE3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="reporte">
        <h3>Reporte de Compra</h3>
        <h4>ID Compra: <?php echo $idCompra; ?></h4>

        <table>
            <tr>
                <th>Fecha</th>
                <td><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <th>Proveedor</th>
                <td><?php echo $proveedor; ?></td>
            </tr>
            <tr>
                <th>Tipo de Pago</th>
                <td><?php echo $tipoPago; ?></td>
            </tr>

            <tr>
                <th>Productos</th>
    <td>
        <ul>
            <?php foreach ($productos as $producto): ?>
                <li><?php echo $producto; ?></li>
                
            <?php endforeach; ?>
        </ul>
    </td>
            </tr>
            <tr>
            <th>Total productos</th>
                <td><?php echo number_format($totaldc, 2); ?></td>
            </tr>
            
        </table>

        <br>

        <div >
            <div>
            <button onclick='window.print()' class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            IMPRIMIR
        </button>
        </div>

        <br>
        <div>
            <a href="excel_x_compra.php?id=<?php echo $idCompra; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR EXCEL
</a>
        </div>
    
    </div>
</body>
</html>