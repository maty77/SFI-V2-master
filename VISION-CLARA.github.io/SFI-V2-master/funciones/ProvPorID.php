<?php 
function obtenerDatosProveedorPorId($Id) {
    $conexion = ConexionBD(); 

    $query = "SELECT PROVEEDOR, CONTACTO, DOMICILIO, CIUDAD, Email FROM proveedor WHERE ID_PROVEEDOR = ?";
    
    if ($stmt = $conexion->prepare($query)) {

        $stmt->bind_param("s", $Id);
        
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