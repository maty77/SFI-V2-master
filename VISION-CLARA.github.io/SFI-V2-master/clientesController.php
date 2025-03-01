<?php
require_once 'conexion.php';
require_once 'funciones/mostrarClientes.php';
require_once 'funciones/insertCliente.php';

$MiConexion = $conexion;  // Reutilizamos la conexión central

$mensajeC = "";
$mensajeE = "";
$ListadoCli = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
        $resultado = InsertarCliente($MiConexion);
        $mensajeC = $resultado ? "Registro Exitoso." : "Error al intentar insertar el registro.";
    } elseif (isset($_POST['buscar_dni'])) {
        $dni = trim($_POST['dni']);
        $ListadoCli = buscarClientePorDNI($MiConexion, $dni);
    }
} else {
    $ListadoCli = ListarClientes($MiConexion);
}

$CantidadCli = count($ListadoCli);

function buscarClientePorDNI($conexion, $dni) {
    $Listado = [];
    $stmt = $conexion->prepare("SELECT c.NOMBRE AS NOM_CLI, c.APELLIDO AS APE_CLI, c.DNI_CLI, c.Email AS MAIL_CLI, c.CIUDAD AS CIU_CLI, p.PROVINCIA_DESC AS PROVINCIA, c.CONTACTO AS CON_CLI
                                 FROM cliente c
                                 JOIN provincia p ON p.ID_PROV = c.ID_PROV
                                 WHERE c.Disponibilidad = 1 AND c.DNI_CLI = ?");
    $stmt->bind_param("i", $dni);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        $Listado[] = $fila;
    }
    $stmt->close();
    return $Listado;
}
?>
