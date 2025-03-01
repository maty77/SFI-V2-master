<?php
function verificarConexionBD($Host = 'localhost', $User = 'root', $Password = '', $BaseDeDatos = 'OPTICAVISION') {
    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos);
    
    if ($linkConexion) {
        echo "<p>Conexión correcta a la base de datos</p>";
        mysqli_close($linkConexion);
    } else {
        echo "<p>Error al conectar a la base de datos: " . mysqli_connect_error() . "</p>";
    }
}
?>