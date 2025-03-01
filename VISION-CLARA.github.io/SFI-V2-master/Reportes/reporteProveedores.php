<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

$SQL = "SELECT prov.proveedor as nombre, 
               prov.id_proveedor as cuit,
               prov.email as email,
               prov.ciudad as ciudad,
               prov.domicilio as domicilio,
               p.Provincia_desc as provincia,
               prov.contacto as contacto
        FROM Proveedor prov
        INNER JOIN provincia p ON p.id_prov = prov.id_prov
        WHERE prov.Disponibilidad = 1";

$result = $MiConexion->query($SQL);

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proveedores Activos</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <style>
        html {
            background-color: white;
        }
        body {
            color: #0F0768;
            background-color: white;
        }
        .reporte {
            padding: 2px;
            border-radius: 5px;
            margin: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }
        h1, h2, h3 {
            text-align: center;
            color: #333;
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
            text-align: center;
            white-space: normal;
            word-break: break-word;
        }
        th {
            background-color: #B1ACE3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
        @media print {
            .reporte {
                max-width: 100%; 
                overflow: visible;
                page-break-inside: avoid;
            }
            table {
                width: 100%;
            }
            button, a { 
                display: none; 
            }
        }
    </style>
</head>
<body>
    <div class="reporte">
        <h3>Reporte de Proveedores Activos</h3>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>CUIT</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Domicilio</th>
                        <th>Provincia</th>
                        
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['cuit']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['ciudad']) ?></td>
                            <td><?= htmlspecialchars($row['domicilio']) ?></td>
                            <td><?= htmlspecialchars($row['provincia']) ?></td>

                            <td><?= htmlspecialchars($row['contacto']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <br>
             <div>
            <div>
            <a href="pdf_proveedores_activos.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR PDF</a>
        </div>

        <br>
        <div>
            <a href="excel_proveedores.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR EXCEL
</a>
        </div>
        <?php endif; ?>
    </div>

    
</body>
</html>
