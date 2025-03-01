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
        $user_id = intval($_POST['DNI_CLI']);
        $sql = "UPDATE cliente SET disponibilidad = 1 WHERE DNI_CLI = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensajeC2 = "Cliente dado de ALTA con éxito.";
                } else {
                    $mensajeE2 = "No se encontró ningún Cliente con el ID proporcionado o ya está actualizado.";
                }
            } else {
                $mensajeE2 = "Error al actualizar la disponibilidad del Cliente: " . $stmt->error;
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