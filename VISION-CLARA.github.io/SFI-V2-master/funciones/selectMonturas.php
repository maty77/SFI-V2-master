<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

$idVentaActual = $nuevoID;

$queryMonturas = "SELECT p.id_prod, p.producto 
                  FROM detalleventa dv 
                  JOIN producto p ON dv.id_prod = p.id_prod 
                  WHERE dv.id_venta = ? AND p.id_tipoprod = 2";

$statement = $MiConexion->prepare($queryMonturas);

if (!$statement) {
    die("Error en la consulta: " . $MiConexion->error);
}

$statement->bind_param('i', $idVentaActual);
$statement->execute();
$resultado = $statement->get_result();
$monturasAgregadas = $resultado->fetch_all(MYSQLI_ASSOC);

?>