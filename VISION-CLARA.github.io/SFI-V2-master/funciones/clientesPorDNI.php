<?php 
function obtenerDatosClientePorDNI($dni) {
    $conexion = ConexionBD();

    $query = "SELECT NOMBRE, APELLIDO, DOMICILIO, CIUDAD, CONTACTO, Email FROM cliente WHERE DNI_CLI = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("s", $dni);
        
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
        
        $stmt->close();
    }
    
    $conexion->close();
    
    return null;
}
 ?>