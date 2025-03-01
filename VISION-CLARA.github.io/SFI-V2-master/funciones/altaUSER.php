<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opticavision";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['BtnAlta'])) {
    $mensajeC2 = ''; 
    $mensajeE2 = '';
    if ($_POST['accion'] === 'dar_alta') {
        $user_id = intval($_POST['DNI']);
        $sql = "UPDATE usuario SET disponibilidad = 1 WHERE DNI_U = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensajeC2 = "Usuario dado de ALTA con éxito.";
                } else {
                    $mensajeE2 = "No se encontró ningún usuario con el ID proporcionado o ya está actualizado.";
                }
            } else {
                $mensajeE2 = "Error al actualizar la disponibilidad del usuario: " . $stmt->error;
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