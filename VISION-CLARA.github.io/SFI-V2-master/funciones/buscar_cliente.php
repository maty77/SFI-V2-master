<?php
require_once 'conexion.php';
$MiConexion = ConexionBD();

// Inicializamos el array de clientes
$ListadoCli = array();

if (isset($_POST['buscar_dni'])) {
    $dni = trim($_POST['dni']);
    
    $stmt = $MiConexion->prepare("SELECT * FROM cliente WHERE DNI_CLI = ?");
    $stmt->bind_param("i", $dni); 
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    while ($fila = $resultado->fetch_assoc()) {
        $ListadoCli[] = $fila;
    }
    
    $stmt->close();
} else {
    // No se realizó búsqueda, mostramos todos los clientes activos
    require_once 'mostrarClientes.php';
    $ListadoCli = ListarClientes($MiConexion);
}

$CantidadCli = count($ListadoCli);
?>