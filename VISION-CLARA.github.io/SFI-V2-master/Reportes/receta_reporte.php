<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


if (isset($_GET['id_receta']) && is_numeric($_GET['id_receta'])) {
    $idReceta = intval($_GET['id_receta']);
    
    //Consulta para obtener las recetas con sus tratamientos y cristales
    $sqlRecetaDatos = "SELECT 
        r.id_receta,
        r.fecha,
        v.ID_VENTA, 
        cli.DNI_CLI,
        cli.nombre,
        cli.apellido, 
        en.entrega,
        p.id_prod, 
        p.producto,
        p.precio_venta as precioprod,
        cob.cobertura, 
        c.tipo_cristal,
        r.ojo_der_esf,
        r.ojo_der_cil,
        r.ojo_izq_esf,
        r.ojo_izq_cil,
        r.indice_refraccion,
        c.precio AS cristalprecio,
        GROUP_CONCAT(DISTINCT t.tipo_trat SEPARATOR ', ') AS tratamientos,
        GROUP_CONCAT(DISTINCT t.precio SEPARATOR ', ') AS tratprecio
    FROM venta_receta rv
INNER JOIN venta v ON v.id_venta = rv.id_venta
INNER JOIN detalleventa dv ON v.id_venta = dv.id_venta
INNER JOIN cliente cli ON cli.DNI_CLI = v.DNI_CLI
INNER JOIN tipoentrega en ON en.id_ent = v.id_ent
INNER JOIN cobertura cob ON cob.id_cob = v.id_cob

LEFT JOIN producto p ON rv.id_prod = p.id_prod
    LEFT JOIN Receta r ON rv.id_receta = r.id_receta
    LEFT JOIN Cristales c ON r.id_cristal = c.id_cristal
    LEFT JOIN receta_tratamientos rt ON r.id_receta = rt.id_receta
    LEFT JOIN tratamientos t ON rt.id_trat = t.id_trat
    WHERE rv.id_receta = ?
    GROUP BY r.id_receta, c.id_cristal;";
    
    $stmtRecetaDatos = $MiConexion->prepare($sqlRecetaDatos);
    if (!$stmtRecetaDatos) {
        die("Error en la preparación de datos generales: " . $MiConexion->error);
    }
    $stmtRecetaDatos->bind_param("i", $idReceta);
    $stmtRecetaDatos->execute();
    $resultadoRecetaDatos = $stmtRecetaDatos->get_result();

    if ($resultadoRecetaDatos->num_rows > 0) {
        $Receta = $resultadoRecetaDatos->fetch_assoc();
    } else {
        echo "No se encontró la venta con el ID especificado.";
        exit;
    }
}


$idreceta = $Receta['id_receta'];
$idventa = $Receta['ID_VENTA'];
$dnicliente = $Receta['DNI_CLI'];
$nombre = $Receta['nombre'];
$apellido = $Receta['apellido'];
$entrega = $Receta['entrega'];
$idProducto = $Receta['id_prod'];
$producto = $Receta['producto'];
$precioventa = $Receta['precioprod'];
$cobertura = $Receta['cobertura'];
$t_cristal = $Receta['tipo_cristal'];
$crisprecio = $Receta['cristalprecio'];
$trat = $Receta['tratamientos'];
$tratprecio = $Receta['tratprecio'];
$fecha = $Receta['fecha'];
$ojoderesf = $Receta['ojo_der_esf'];
$ojodercil = $Receta['ojo_der_cil'];
$ojoizqesf = $Receta['ojo_izq_esf'];
$ojoizqcil = $Receta['ojo_izq_cil'];
$indice = $Receta['indice_refraccion'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante y Factura</title>
     <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <style>
        html{
            background-color: white;
            font-size: 12px;
        }
        body {
            font-family: monospace;
          margin: 20px;
          color: #0F0768;
          background-color: white;

      }
        .reporte {
          width: 55%;
          border: 1px solid #ccc;
          padding: 20px;
          border-radius: 5px;
          margin: auto;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
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
    justify-content: center; /* para alinear horizontalmente a la derecha */
    align-items: center;       /* para centrar verticalmente los elementos dentro del contenedor */
}
       .img {
          width: 150px;
          padding: 25px;
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
    </style>
</head>
<body>

<div class="reporte">
<div class="comprobante">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img">
            <b>Detalle de Receta</b> 
            <b> - - - - </b>
            <b>ID Receta:<?php echo $idreceta; ?></b>
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/clases/VISION%20CLARA/SFI-V2-master/assets/img/home.png" class="img">
        </div>

    <div>
        

        <table>
            <tr>
                <th>Venta</th>
                <td><?php echo $idventa; ?></td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <th>Cliente</th>
           <td> <ul>
                <li>DNI: <?php echo $dnicliente; ?></li>
                <li>Nombre: <?php echo $nombre; ?></li>
                <li>Apellido: <?php echo $apellido; ?></li>
            </ul></td>
            </tr>
             <tr>
                <th>Forma entrega</th>
                <td><?php echo $entrega; ?></td>
            </tr>

            <tr>
                <th>Producto</th>
    <td>
        <ul>
                <li><?php echo $idProducto. " - " .$producto. " - Precio: $" .$precioventa; ?></li>
        </ul>
    </td>
            </tr>
             <tr>
                <th>Cobertura medica</th>
                <td><?php echo $cobertura; ?></td>
            </tr>
            <tr>
                <th class="tit-receta">Cristal</th>
            <td> <ul>
                <li><?php echo $t_cristal. " - Precio: $" . $crisprecio; ?></li>
            </td> </ul>
            </tr>
            <tr>
                <th class="tit-receta">Tratamiento/s</th>
            <td> <ul>
                <li><?php echo $trat . " - Precio: $" . $tratprecio; ?></li>
            </td> </ul>
            </tr>
             <tr>
                <th class="tit-receta">Indice de refraccion</th>
                <td><?php echo $indice; ?></td>
            </tr>
        
        <tr>
                <th class="tit-receta">Ojo Derecho</th>
           <td> <ul>
                <li>Esfera: <?php echo $ojoderesf. " - Cilindro: " .$ojodercil; ?></li>
            </ul></td>
            </tr>

             <tr>
                <th class="tit-receta">Ojo Izquierdo</th>
           <td> <ul>
                <li>Esfera: <?php echo $ojoizqesf. " - Cilindro: " .$ojoizqcil; ?></li>
            </ul></td>
            </tr>
            
        </table>
    </div>
</div>
        <div class="footer">
    <a href="pdf_receta.php?id_receta=<?php echo $idReceta; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
    DESCARGAR PDF</a>
        </div>
    



</body>
</html>
