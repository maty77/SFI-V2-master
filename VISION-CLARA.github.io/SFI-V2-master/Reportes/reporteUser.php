<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

$SQL = "SELECT  u.nombre AS nombre, 
                u.apellido AS apellido, 
                u.DNI_U AS dni, 
                u.usuario AS usuario, 
                u.contacto AS contacto
        FROM usuario u, jerarquia j
        WHERE  u.id_jer=j.id_jer AND u.id_jer = 2 AND u.Disponibilidad = 1
        ORDER BY u.apellido ASC";

$result = $MiConexion->query($SQL);

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios Activos</title>
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
            width: 1000px;
        }
        h1, h2, h3 {
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
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="reporte">
        <h3>Reporte de Usuarios Activos</h3>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Usuario</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['apellido']) ?></td>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['dni']) ?></td>
                            <td><?= htmlspecialchars($row['usuario']) ?></td>
                            <td><?= htmlspecialchars($row['contacto']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <br>
             <div >
             <div>
            <a href="pdf_users_activos.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR PDF</a>
        </div>

        <br>
        <div>
            <a href="excel_users.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR EXCEL
</a>
        </div>
        <?php endif; ?>
    </div>

    
</body>
</html>
