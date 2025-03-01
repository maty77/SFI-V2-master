<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opticavision";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['BtnAlta'])) {

    $mensajeE2 = '';
    $mensajeC2 = '';
    if ($_POST['accion'] === 'dar_alta') {
        $user_id = intval($_POST['ID_PROVE']);
        $sql = "UPDATE proveedor SET disponibilidad = 1 WHERE ID_PROVEEDOR = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensajeC2 = "Proveedor dado de ALTA con éxito.";
                } else {
                    $mensajeE2 = "No se encontró ningún Proveedor con el ID proporcionado o ya está actualizado.";
                }
            } else {
                $mensajeE2 = "Error al actualizar la disponibilidad del Proveedor: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $mensajeE2 = "Error al preparar la consulta: " . $conn->error;
        }
    }
    $conn->close();
return $mensajeE2;

}
?>