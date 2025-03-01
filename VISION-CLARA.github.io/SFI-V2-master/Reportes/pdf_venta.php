<?php
// Incluir conexión y autenticación
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

ob_start();

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
            GROUP_CONCAT(DISTINCT t.precio SEPARATOR ', ') AS tratprecio,
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

$fecha      = $venta['FECHA'];
$DNI_U      = $venta['DNI_U'];
$DNI_CLI    = $venta['DNI_CLI'];
$totalventa = $venta['total'];
$promo      = $venta['promo'];
$descuento  = $venta['valor_descuento'];
$cobertura  = $venta['cobertura'];
$pago       = $venta['pago'];
$entrega    = $venta['entrega'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comprobante y Factura</title>
  <style>
      body {
          font-family: monospace;
          margin: 20px;
          color: #0F0768;
      }
      .reporte {
        width: auto;
          border: 1px solid #ccc;
          padding: 20px;
          border-radius: 5px;
          margin: auto;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      }
        h3, h4 {
          text-align: center;
          margin: 0;
      }
      table {
          width: 100%;
          border-collapse: collapse;
      }
      th, td {
          border: 1px solid #ddd;
          padding: 5px;
          text-align: left;
          font-size: 12px;
      }
      th {
          background-color: #B1ACE3;
          font-size: 12px;
      }
      .footer {
          text-align: center;
          margin-top: 10px;
          font-size: 0.9em;
          color: #555;
          height: 5px;
      }
      .comprobante {
        display: flex;
        align-items: right;
          border: 1px solid #ccc;
          padding: 30px;
          padding-bottom: 0px;
          border-radius: 5px;
          margin: auto;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      }
      .img {
          width: 150px;

      }
      .img2 {
          width: 150px;
      }
     
      .firmas {
          border-top: none;
          padding-bottom: 30px;
      }
      .firmas2 {
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
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img">
            <b class="headcomp">Comprobante</b> <b>----</b>
            <b class="headcomp_fecha">ID Venta: <?php echo $idVenta; ?></b>
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img2">
        </div>
        <table >
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
        <table>
            <tr>
                <td class="firmas2">Fecha de entrega</td>
                <td class="firmas2">Firma y aclaración cliente</td>
                <td class="firmas2">Firma y aclaración vendedor</td>
            </tr>
            <tr>
                <td class="firmas"></td>
                <td class="firmas"></td>
                <td class="firmas"></td>
            </tr>
        </table>
<hr>
<div></div>
<div class="reporte">
    <h3>Detalle de Venta</h3>
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
            <th colspan="2">Recetas de la venta</th>
        </tr>
        <?php if (!empty($recetas)): ?>
            <?php foreach ($recetas as $receta): ?>
                <tr class="tit-receta">
                    <td><strong>ID Receta:</strong></td>
                    <td><?php echo $receta['id_receta']; ?></td>
                </tr>
                <tr class="receta">
                    <td><strong>Cristal:</strong></td>
                    <td><?php echo $receta['tipo_cristal']. '. PRECIO $' . $receta['cprecio'] . ''; ?></td>
                </tr>
                <tr class="receta">
                    <td><strong>Tratamientos:</strong></td>
                    <td><?php echo $receta['tratamientos']. '.  PRECIO/S $' . $receta['tratprecio'] . ''; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="receta" colspan="2">No hay recetas asociadas a esta venta.</td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>Promoción</th>
            <td><?php echo $promo; ?></td>
        </tr>
        <tr>
            <th>Descuento</th>
            <td><?php echo $descuento . '%'; ?></td>
        </tr>
        <tr>
            <th>TOTAL VENTA</th>
            <td><?php echo $totalventa; ?></td>
        </tr>
        <tr>
            <th>Cobertura médica</th>
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
</body>
</html>

<?php
$html = ob_get_clean();

require_once '../pdf/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->setBasePath('http://localhost/clases/VISION%20CLARA/SFI-V2-master');

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("comprobante_venta_$idVenta.pdf", array("Attachment" => false));
?>
