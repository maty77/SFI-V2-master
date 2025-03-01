<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

$idVenta = $_POST['id_venta'];

$queryMonturas = "SELECT p.id_prod, p.producto 
                  FROM detalleventa dv 
                  JOIN producto p ON dv.id_prod = p.id_prod 
                  WHERE dv.id_venta = :id_venta AND p.id_tipoprod = 2";

$statement = $MiConexion->prepare($queryMonturas);
$statement->bindParam(':id_venta', $idVenta, PDO::PARAM_INT);
$statement->execute();

$monturasAgregadas = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($monturasAgregadas);
?>