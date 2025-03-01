<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';

require_once '../funciones/mostrarProd_Stock.php';


// Obtener el filtro si existe
$stock_level = isset($_GET['stock_level']) ? $_GET['stock_level'] : '';
$id_tipoprod = isset($_GET['id_tipoprod']) ? $_GET['id_tipoprod'] : '';

$ListadoInventario = ListarInventario($MiConexion, $id_tipoprod);

$ListadoFiltrado = [];
foreach ($ListadoInventario as $item) {
    if ($item['STOCK'] == 0) {
        $stockCategory = 'agotado';
    } elseif ($item['STOCK'] > 150) {
        $stockCategory = 'alto';
    } elseif ($item['STOCK'] > 30) {
        $stockCategory = 'medio';
    } else {
        $stockCategory = 'bajo';
    }

    if (!empty($stock_level) && $stock_level != $stockCategory) {
        continue; 
    }

    $ListadoFiltrado[] = $item;
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_inventario.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "PRODUCTO\tMODELO\tMARCA\tCODIGO PROD\tCANT. COMPRA\tCANT. VENTA\tSTOCK\tPRECIO COMPRA\tPRECIO VENTA\n";

foreach ($ListadoFiltrado as $item) {
    echo "{$item['PROD']}\t{$item['MODELO']}\t{$item['MARCA']}\t{$item['IDPROD']}\t{$item['CANTIDADC']}\t{$item['CANTIDADV']}\t{$item['STOCK']}\t{$item['PRECIOC']}\t{$item['PRECIOV']}\n";
}
?>