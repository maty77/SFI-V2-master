<?php 
function obtenerDatosCompraPorId($id) {
    $conexion = ConexionBD(); 

    $query = "SELECT  pro.proveedor, p.producto, p.modelo, dc.cantprod, dc.totalcompra, tp.pago, c.fecha
                FROM compra c, detallecompra dc, producto p, tipopago tp, proveedor pro
                WHERE p.id_prod=dc.id_prod AND pro.id_proveedor=c.id_proveedor AND tp.id_pago=c.id_pago AND dc.id_compra = ?";
    
    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("s", $id);
        
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}
return $datos;
        } else {
            return null;
        }
        
        $stmt->close();
    }
    
    $conexion->close();
    
    return null;
}
 ?>