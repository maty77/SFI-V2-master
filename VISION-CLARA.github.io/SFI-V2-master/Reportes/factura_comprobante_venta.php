<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


if (isset($_GET['id_venta']) && is_numeric($_GET['id_venta'])) {
    $idVenta = intval($_GET['id_venta']);

    //Consulta para obtener los datos generales de la venta
    $sqlVentaGeneral = "SELECT 
        v.FECHA, 
        u.DNI_U, 
        cli.DNI_CLI, 
        v.total, 
        pro.promo, 
        pro.valor_descuento, 
        cob.cobertura, 
        fp.pago, 
        en.entrega
    FROM venta v 
    INNER JOIN detalleventa dv ON v.id_venta = dv.id_venta
    INNER JOIN usuario u ON u.DNI_U = v.DNI_U
    INNER JOIN cliente cli ON cli.DNI_CLI = v.DNI_CLI
    INNER JOIN promociones pro ON pro.id_promo = v.id_promo
    INNER JOIN cobertura cob ON cob.id_cob = v.id_cob
    INNER JOIN tipopago fp ON v.id_pago = fp.id_pago
    INNER JOIN tipoentrega en ON en.id_ent = v.id_ent
    WHERE v.id_venta = ?
    GROUP BY v.id_venta;";
    
    $stmtVentaGeneral = $MiConexion->prepare($sqlVentaGeneral);
    if (!$stmtVentaGeneral) {
        die("Error en la preparación de datos generales: " . $MiConexion->error);
    }
    $stmtVentaGeneral->bind_param("i", $idVenta);
    $stmtVentaGeneral->execute();
    $resultadoVentaGeneral = $stmtVentaGeneral->get_result();

    if ($resultadoVentaGeneral->num_rows > 0) {
        $venta = $resultadoVentaGeneral->fetch_assoc();
    } else {
        echo "No se encontró la venta con el ID especificado.";
        exit;
    }
    
    //Consulta para obtener las recetas con sus tratamientos y cristales
    $sqlRecetas = "SELECT 
        r.id_receta,
        c.tipo_cristal,
        GROUP_CONCAT(t.tipo_trat SEPARATOR ', ') AS tratamientos,
        t.precio AS tprecio,
        c.precio AS cprecio
    FROM venta_receta rv
    LEFT JOIN Receta r ON rv.id_receta = r.id_receta
    LEFT JOIN Cristales c ON r.id_cristal = c.id_cristal
    LEFT JOIN receta_tratamientos rt ON r.id_receta = rt.id_receta
    LEFT JOIN tratamientos t ON rt.id_trat = t.id_trat
    WHERE rv.id_venta = ?
    GROUP BY r.id_receta, c.id_cristal;";
    
    $stmtRecetas = $MiConexion->prepare($sqlRecetas);
    if (!$stmtRecetas) {
        die("Error en la preparación de recetas: " . $MiConexion->error);
    }
    $stmtRecetas->bind_param("i", $idVenta);
    $stmtRecetas->execute();
    $resultadoRecetas = $stmtRecetas->get_result();
    
    $recetas = [];
    while ($row = $resultadoRecetas->fetch_assoc()) {
        $recetas[] = $row;
    }
    
    //Consulta para obtener los productos del detalle de la venta
    $sqlProductos = "SELECT dv.id_prod, dv.cantprod, dv.totalventa, p.producto
    FROM detalleventa dv
    INNER JOIN producto p ON p.id_prod = dv.id_prod
    WHERE dv.id_venta = ?";
    $stmtProductos = $MiConexion->prepare($sqlProductos);
    if (!$stmtProductos) {
        die("Error en la preparación de productos: " . $MiConexion->error);
    }
    $stmtProductos->bind_param("i", $idVenta);
    $stmtProductos->execute();
    $resultadoProductos = $stmtProductos->get_result();
    
    $productos = [];
    while ($producto = $resultadoProductos->fetch_assoc()) {
        $productos[] = $producto['producto'] . " (Cant: " . $producto['cantprod'] . ")";
    }
    
    //Consulta para obtener la suma total de la venta
    $sqlTotalVenta = "SELECT SUM(totalventa) AS total_suma FROM detalleventa WHERE id_venta = ?";
    $stmtTotalVenta = $MiConexion->prepare($sqlTotalVenta);
    if (!$stmtTotalVenta) {
        die("Error en la preparación de total de venta: " . $MiConexion->error);
    }
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

$fecha       = $venta['FECHA'];
$DNI_U       = $venta['DNI_U'];
$DNI_CLI     = $venta['DNI_CLI'];
$totalventa  = $venta['total'];
$promo       = $venta['promo'];
$descuento   = $venta['valor_descuento'];
$cobertura   = $venta['cobertura'];
$pago        = $venta['pago'];
$entrega     = $venta['entrega'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante y Factura</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            font-family: monospace;
            margin: 20px;
            color: #0F0768;

        }
        .reporte {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h1, h2, h3 {
            text-align: center;
            margin:0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color:#B1ACE3;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
                height: 5px;
        }
        .comprobante{
            display: flex;
        align-items: right;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .img{
            width: 18%;
            display: inline-block;
        }
        .img2{
            width: 18%;
            display: inline-block;

        }
        .headcomp{
            display: inline-block;
            text-align: center;
            padding: 1%;
            margin: 3%;
            font-size: 125%;
        }
        .headcomp_fecha{
            display: inline-block;
            text-align: center;
            padding: 1%;
            margin: 3%;
            font-size: 125%;

        }
      
        .head{
            align-content: center;
            align-items: center;
        }
        .firmas{
            border-top: none;
        }
        .firmas2{
            border-bottom: none;
        }
        .tit-receta {
          background-color: #757ff5;
      }
      .receta{
        background-color: #9fa6fe;
      }
    </style>
</head>
<body>

<div class="comprobante">

    <img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img">
    <b  class="headcomp">Comprobante</b>
        <b  class="headcomp_fecha">ID Venta: <?php echo $idVenta; ?></b>
         <img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img2">
        </div><table class="tabla2">
        <tr>
                <th>TOTAL VENTA</th>
                <th>Fecha</th>
                <th>Forma de pago</th>
                <th>Forma entrega</th>
            </tr>
            <tr>
                <td><?php echo $totalventa; ?></td>
                <td><?php echo $fecha; ?></td>
            
                <td><?php echo $pago; ?></td>
            
                
                <td><?php echo $entrega; ?></td>
            </tr>
</table>
<br>



<hr>
    <div class="reporte">
        <h2>Detalle de Venta</h2>
        <h3>ID Venta: <?php echo $idVenta; ?></h3>

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
    <th colspan="2">Recetas de la venta</th>
</tr>
<?php if(!empty($recetas)): ?>
    <?php foreach($recetas as $receta): ?>
        <tr class="tit-receta">
            <td><strong>ID Receta:</strong></td>
            <td><?php echo $receta['id_receta']; ?></td>
        </tr>
        <tr class="receta">
            <td><strong>Cristal:</strong></td>
            <td><?php echo $receta['tipo_cristal']. ' + $' . $receta['cprecio'] . ''; ?></td>
        </tr>
        <tr class="receta">
            <td><strong>Tratamientos:</strong></td>
            <td><?php echo $receta['tratamientos']. ' + $' . $receta['tprecio'] . ''; ?></td>
        </tr>
       
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td class="receta" colspan="2">No hay recetas asociadas a esta venta.</td>
    </tr>
<?php endif; ?>
            
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
    </div>
        <div class="footer">
    <a href="pdf_venta.php?id_venta=<?php echo $idVenta; ?>" class="boton-descargar ">
        Descargar PDF
    </a>
</div>



</body>
</html>
