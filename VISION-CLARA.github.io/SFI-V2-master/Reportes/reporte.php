<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';
require_once '../funciones/selectTipoProd.php';
require_once '../funciones/mostrarProd_Stock.php';

$stock_level = isset($_GET['stock_level']) ? $_GET['stock_level'] : '';

$id_tipoprod = isset($_GET['id_tipoprod']) ? $_GET['id_tipoprod'] : '';

$ListadoInventario = ListarInventario($MiConexion, $id_tipoprod);
$CantidadItem = count($ListadoInventario);

$ListadoTipo = ListarTipoProd($MiConexion);
$tipoDescripcion = '';
if (!empty($id_tipoprod)) {
    foreach ($ListadoTipo as $tipo) {
        if ($tipo['IDTIPO'] == $id_tipoprod) {
            $tipoDescripcion = $tipo['TIPODESC'];
            break;
        }
    }
}


$mensajeFiltro = 'Reporte de Inventario';

if (!empty($tipoDescripcion)) {
    $mensajeFiltro .= " por tipo de Producto: " . $tipoDescripcion;
}

if (!empty($stock_level)) {
    // Convertir el valor del stock a una descripción legible
    switch ($stock_level) {
        case 'alto':
            $stockTexto = 'Stock Alto';
            break;
        case 'medio':
            $stockTexto = 'Stock Medio';
            break;
        case 'bajo':
            $stockTexto = 'Stock Bajo';
            break;
        case 'agotado':
            $stockTexto = 'Agotado';
            break;
        default:
            $stockTexto = $stock_level;
    }
    $mensajeFiltro .= " por Nivel de Stock: " . $stockTexto;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de Inventario</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/material.min.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <style>
        html{
            background-color: white;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: white;
        }
        .reporte {
            border: 1px solid #ccc;
            padding: 0px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 5%;
        }
        h1, h2, h3 {
            text-align: left;
        }
        
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: #b6bdf8;
        }
        th {
            background-color: #6a79f8;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        
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
<div  class="reporte">
         <h5><?php echo $mensajeFiltro; ?></h5>
        <table>
                <tr>
                    <th>PRODUCTO</th>
                    <th>MODELO</th>
                    <th>MARCA</th>
                    <th>CODIGO PROD</th>
                    <th>CANT. COMPRA</th>
                    <th>CANT. VENTA</th>
                    <th>STOCK</th>
                    <th>PRECIO COMPRA</th>
                    <th>PRECIO VENTA</th>
                </tr>
                <?php foreach ($ListadoInventario as $item): 
            // Determinar la categoría de stock para aplicar el filtro
            if ($item['STOCK'] == 0) {
                $stockCategory = 'agotado';
            } elseif ($item['STOCK'] > 150) {
                $stockCategory = 'alto';
            } elseif ($item['STOCK'] > 30) {
                $stockCategory = 'medio';
            } else {
                $stockCategory = 'bajo';
            }

            // Si se aplica un filtro de stock, se omiten los items que no cumplen
            if (!empty($stock_level) && $stock_level != $stockCategory) {
                continue; 
            }
        ?>
    <tr>
        <td class="datos"><?php echo $item['PROD']; ?></td>
        <td class="datos"><?php echo $item['MODELO']; ?></td>
        <td class="datos"><?php echo $item['MARCA']; ?></td>
        <td class="datos"><?php echo $item['IDPROD']; ?></td>
        <td class="datos"><?php echo $item['CANTIDADC']; ?></td>
        <td class="datos"><?php echo $item['CANTIDADV']; ?></td>
        <td class="datos"><?php echo $item['STOCK']; ?></td>
        <td class="datos"><?php echo $item['PRECIOC']; ?></td>
        <td class="datos"><?php echo $item['PRECIOV']; ?></td>
    </tr>
<?php endforeach; ?>
        </table>
</div>  
        <div class="footer">
            <div>
            <button onclick='window.print()' class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            IMPRIMIR
        </button>
        </div>

        <br>

        <div>
    <a href="excel_inventario.php?id_tipoprod=<?php echo $id_tipoprod; ?>&stock_level=<?php echo $stock_level; ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
        DESCARGAR EXCEL
    </a></div>
</div>

</body>
</html>
