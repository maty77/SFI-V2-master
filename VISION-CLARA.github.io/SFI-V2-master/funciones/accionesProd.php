<?php 
require_once 'conexion.php';
$conexion = ConexionBD();

$mensajeC = '';
$mensajeE = '';

if (isset($_POST['accion2'])) {

    $error = false;
    $mensajeError = '';

    // Validar que se haya seleccionado una marca
    if (!isset($_POST['marca']) || empty(trim($_POST['marca']))) {
        $error = true;
        $mensajeError .= "Seleccione una marca. ";
    } else {
        $marca = $_POST['marca'];
    }

    // Validar que se haya seleccionado un producto
    if (!isset($_POST['id_prod']) || empty(trim($_POST['id_prod']))) {
        $error = true;
        $mensajeError .= "Seleccione un producto.";
    } else {
        $productoId = $_POST['id_prod'];
    }

    if ($error) {
        // Si hay error en la selección, se asigna el mensaje de error
        $mensajeE = $mensajeError;
    } else {
        // Si ambas validaciones son correctas, se procede según la acción enviada
        $accion2 = $_POST['accion2'];

        switch ($accion2) {
            case 'modificar':
                header("Location: modificarProd.php?id_prod=$productoId");
                exit();
                break;

            case 'eliminar':
                $query = "DELETE FROM producto WHERE id_prod = ?";
                $stmt = mysqli_prepare($MiConexion, $query);
                mysqli_stmt_bind_param($stmt, "i", $productoId);
                if (mysqli_stmt_execute($stmt)) {
                    $mensajeC = 'Producto eliminado con éxito.';
                } else {
                    $mensajeE = 'Error al eliminar el producto.';
                }
                break;

            case 'archivar':
                $query = "UPDATE producto SET disponibilidad = '0' WHERE id_prod = ?";
                $stmt = mysqli_prepare($MiConexion, $query);
                mysqli_stmt_bind_param($stmt, "i", $productoId);
                if (mysqli_stmt_execute($stmt)) {
                    $mensajeC = 'Producto archivado con éxito.';
                } else {
                    $mensajeE = 'Error al archivar el producto.';
                }
                break;

            default:
                $mensajeE = 'Acción no reconocida.';
        }
    }
}


?>