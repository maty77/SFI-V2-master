<?php 
require_once 'conexion.php';
$conexion = ConexionBD();

$mensajeC = '';
$mensajeE = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $MiConexion = ConexionBD();

    if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {

        if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] == 0) {
            
            $nombreArchivo = basename($_FILES['Imagen']['name']);
            $rutaDestino = "assets/productos/" . $nombreArchivo;

            if (move_uploaded_file($_FILES['Imagen']['tmp_name'], $rutaDestino)) {
                $rutaImagen = $rutaDestino;
            } else {
                $mensajeE = "Error al mover el archivo.";
            }
        } else {
            $mensajeE = "No se ha subido ninguna imagen o ha ocurrido un error.";
        }
        
if (isset($rutaImagen)) {
    $resultado = InsertarProd($MiConexion, $rutaImagen);
} else {
    $rutaImagen = '';
    $resultado = InsertarProd($MiConexion, $rutaImagen);
}

if ($resultado) {
    $mensajeC = "Producto registrado exitosamente.";
} else {
    $mensajeE = "Error al registrar el producto.";
}
}
}

?>