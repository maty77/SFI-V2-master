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
    $mensajeC = ''; 
    $mensajeE = '';
    if ($_POST['accion'] === 'dar_baja') {

        $user_id = intval($_POST['DNI']);
        $sql = "UPDATE usuario SET disponibilidad = 0 WHERE DNI_U = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensajeC = "Usuario dado de BAJA con éxito.";
                } else {
                    $mensajeE = "No se encontró ningún usuario con el ID proporcionado o ya está actualizado.";
                }
            } else {
                $mensajeE = "Error al actualizar la disponibilidad del usuario: " . $stmt->error;
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