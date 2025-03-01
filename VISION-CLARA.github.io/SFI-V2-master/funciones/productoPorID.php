<?php 
function obtenerDatosProductoPorId($Id) {
    $conexion = ConexionBD(); 

    $query = "SELECT p.producto, pro.proveedor, m.marca, p.precio_venta, p.precio_compra, p.imagen, tp.tipoproducto_desc, p.modelo, p.material, p.descripcion FROM producto p, proveedor pro, marca m, tipoproducto tp WHERE pro.id_proveedor=p.id_proveedor AND m.id_marca=p.id_marca AND tp.id_tipoprod=p.id_tipoprod AND id_prod = ?";
    

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("i", $Id);
        
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