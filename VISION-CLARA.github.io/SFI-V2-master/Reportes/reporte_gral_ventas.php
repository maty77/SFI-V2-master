<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

if (isset($_GET['fecha_desde']) && isset($_GET['fecha_hasta'])) {
    $fechaDesde = $_GET['fecha_desde']. " 00:00:00";
    $fechaHasta = $_GET['fecha_hasta']. " 23:59:59";

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

    $totalGeneral = 0;
?>

    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Reporte General de Ventas</title>
        <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
        <style>
            html{
                background-color: white;  
            }
         body {
            background-color: white;  
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .reporte {
            border: 1px solid #ccc;
            padding: 0px;
            border-radius: 5px;
            width: 90%;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            background-color: #b6bdf8;

        }
        th {
            background-color: #6a79f8;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
            .print-button {
                position: fixed;
                top: 10px;
                right: 10px;
                z-index: 1000;
            }
            .total-row {
                font-weight: bold;
                background-color: #f5f5f5;
            }
        </style>
    </head>
    <body>
        <h3>Reporte de Ventas del <?php echo $fechaDesde ?> al <?php echo $fechaHasta ?></h3>
        <table class="reporte">
            <thead>
                <tr>
                    <th><b>FECHA</b></th>
                    <th><b>N° VENTA</b></th>
                    <th><b>TOTAL VENTA</b></th>
                    <th><b>VENDEDOR</b></th>
                    <th><b>FORMA DE PAGO</b></th>
                    <th><b>ENTREGA</b></th>
                </tr>
            </thead>
            <tbody>
                
                <?php
    while ($row = $result->fetch_assoc()) {
        $totalGeneral += $row['totalventa'];
        ?> <tr>
                <td><?php echo $row['fecha'] ?></td>
                <td><?php echo $row['id_venta'] ?></td>
                <td><?php echo $row['total'] ?></td>
                <td><?php echo $row['DNI_U'] ?></td>
                <td><?php echo $row['pago'] ?></td>
                <td><?php echo $row['entrega'] ?></td>
            </tr>
  <?php  } ?>

    <tr class='total-row'>
            <td colspan='2'>Total General</td>
            <td><?php echo $totalGeneral ?></td>
        </tr>

    </tbody>
        </table>
        <div class="footer">
            <div>
            <button onclick='window.print()' class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            IMPRIMIR
        </button>
        </div>

        <br>

        <div>
    <a href="excel_venta_filtrado.php?fecha_desde=<?php echo $fechaDesde; ?>&fecha_hasta=<?php echo $fechaHasta; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">DESCARGAR EXCEL
    </a></div>
    </body>
    </html>
    <?php
} else {
    echo "Error: Fechas no especificadas.";
}
?>