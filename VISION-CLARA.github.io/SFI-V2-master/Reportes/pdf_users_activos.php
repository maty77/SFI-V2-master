<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

ob_start();
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
  <title>PDF Usuarios Activos</title>
  <style>
        body {
            font-family: monospace;
          color: #0F0768;
      }
        .reporte {
          width: auto;
          border: 1px solid #ccc;
          padding: 20px;
          border-radius: 5px;
          margin: auto;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
          font-size: 12px;
      }
        h1, h2, h3, h4, h5 {
            text-align: center;
            margin:0;
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
        align-items: center;
      }
       .img {
          width: 150px;
          padding: 10px;
      }
      .tit {
          background-color: #757ff5;
      }
        .tit-receta {
          background-color: #757ff5;
      }
      .receta{
        background-color: #9fa6fe;
      }
      p{
        font-size: 10px;
        margin-bottom: 0px;
      }
  </style>
</head>
<body>
    <div class="reporte">
        <h3>Reporte de Usuarios Activos</h3>
<?php echo "<p>Descarga: " . date("d/m/Y H:i:s") . "</p>"; ?>
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
             <div >
        <?php endif; ?>
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

$dompdf->stream("users_activos.pdf", array("Attachment" => false));
?>
