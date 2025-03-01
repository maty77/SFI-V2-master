<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opticavision";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['BtnBaja'])) {
    $mensajeE = '';
    $mensajeC = '';
    if ($_POST['accion'] === 'dar_baja') {
        // Obtener el ID del usuario del formulario
        $user_id = intval($_POST['ID_PROVE']);
        $sql = "UPDATE proveedor SET disponibilidad = 0 WHERE ID_PROVEEDOR= ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensajeC = "Proveedor dado de BAJA con éxito.";
                } else {
                    $mensajeE = "No se encontró ningún Proveedor con el ID proporcionado o ya está actualizado.";
                }
            } else {
                $mensajeE = "Error al actualizar la disponibilidad del proveedor: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $mensajeE = "Error al preparar la consulta: " . $conn->error;
        }
    }
    $conn->close();
return $mensajeE;

}
?>