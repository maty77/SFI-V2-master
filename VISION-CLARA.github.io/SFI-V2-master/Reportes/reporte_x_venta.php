<?php 
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idVenta = intval($_GET['id']);

    //Consulta para obtener los datos de la compra
    $sqlVenta = "SELECT v.FECHA, u.DNI_U, cli.DNI_CLI, v.total, pro.promo, pro.valor_descuento, cob.cobertura, fp.pago, en.entrega 
    FROM venta v 
    INNER JOIN detalleventa dv ON v.id_venta=dv.id_venta
    INNER JOIN usuario u ON u.DNI_U=v.DNI_U
    INNER JOIN cliente cli ON cli.DNI_CLI=v.DNI_CLI
    INNER JOIN promociones pro ON pro.id_promo=v.id_promo
    INNER JOIN cobertura cob ON cob.id_cob=v.id_cob
    INNER JOIN tipopago fp ON v.id_pago=fp.id_pago
    INNER JOIN tipoentrega en ON en.id_ent=v.id_ent
    WHERE v.id_venta = ?";
    $stmtVenta = $MiConexion->prepare($sqlVenta);
    $stmtVenta->bind_param("i", $idVenta);
    $stmtVenta->execute();
     $resultadoVenta = $stmtVenta->get_result();


      if ($resultadoVenta->num_rows > 0) {
        $venta = $resultadoVenta->fetch_assoc();
    } else {
        echo "No se encontró la venta con el ID especificado.";
        exit;
    }

    //Consulta para obtener los productos del detalle de la venta
    $sqlProductos = "SELECT dv.id_prod, dv.cantprod, dv.totalventa, p.producto
    FROM detalleventa dv
    INNER JOIN producto p ON p.id_prod = dv.id_prod
    WHERE dv.id_venta = ?";
    $stmtProductos = $MiConexion->prepare($sqlProductos);
    $stmtProductos->bind_param("i", $idVenta);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();

    $productos = [];
    while ($producto = $resultadoProductos->fetch_assoc()) {
        $productos[] = $producto['producto'] . " (Cant: " . $producto['cantprod'] . ")";
    }


  //Consulta para obtener la suma del totalventa
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


$fecha = $venta['FECHA'];
$DNI_U = $venta['DNI_U'];
$DNI_CLI = $venta['DNI_CLI'];
$totalventa = $venta['total'];
$promo = $venta['promo'];
$descuento = $venta['valor_descuento'];
$cobertura = $venta['cobertura'];
$pago = $venta['pago'];
$entrega = $venta['entrega'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Venta</title>
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
            color: #0F0768;
            background-color: white;
        }
        .reporte {
            padding: 2px;
            border-radius: 5px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
            width: 1000px;
        }
        h1, h2, h3, h4{
            text-align: center;
        }
        table {
            table-layout: auto;
            word-wrap: break-word;
            width: 100%;
            border-collapse: collapse;
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
        <h3>Reporte de Venta</h3>
        <h4>ID Venta: <?php echo $idVenta; ?></h4>

        <table>
            <tr>
                <th>Fecha</th>
                <td><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <th>Vendedor</th>
                <td><?php echo $DNI_U; ?></td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td><?php echo $DNI_CLI; ?></td>
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
                <td><?php echo number_format($totaldv, 2); ?></td>
            </tr>
            
            <tr>
                <th>Promocion</th>
                <td><?php echo $promo; ?></td>
            </tr>
            <tr>
                <th>Descuento</th>
                <td><?php echo $descuento.'%'; ?></td>
            </tr>
            <tr>
                <th>TOTAL VENTA</th>
                <td><?php echo $totalventa; ?></td>
            </tr>
            <tr>
                <th>Cobertura medica</th>
                <td><?php echo $cobertura; ?></td>
            </tr>
            <tr>
                <th>Forma de pago</th>
                <td><?php echo $pago; ?></td>
            </tr>
            <tr>
                <th>Forma entrega</th>
                <td><?php echo $entrega; ?></td>
            </tr>

            
        </table>
<br>
        <div>
        <div>
        <a href="pdf_x_venta.php?id=<?php echo $idVenta; ?>"class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" data-id="<?php echo $idVenta; ?>"> DESCARGAR PDF
   </a>
        </div>
        <br>
        <div>
    <a href="excel_x_venta.php?id=<?php echo $idVenta; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR EXCEL
    </a>
        </div>
    </div>
</body>
</html>
