<?php
require_once 'conexion.php';
require_once 'funciones/mostrarproducto.php';
require_once 'funciones/selectMarca.php';
require_once 'funciones/selectProveedor.php';
require_once 'funciones/selectTipoProd.php';

$MiConexion = $conexion;

$ListadoProd = ListarProd($MiConexion);
$ListadoMarca = ListarMarca($MiConexion);
$ListadoProv = ListarProve($MiConexion);
$ListadoTipo = ListarTipoProd($MiConexion);

$CantidadProd = count($ListadoProd);
$CantidadMarca = count($ListadoMarca);
$CantidadProv = count($ListadoProv);
$CantidadTipo = count($ListadoTipo);

// Obtener marcas distintas
$query = "SELECT DISTINCT marca FROM marca";
$result = $MiConexion->query($query);
$ListadoMarcas = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ListadoMarcas[] = $row['marca'];
    }
}
