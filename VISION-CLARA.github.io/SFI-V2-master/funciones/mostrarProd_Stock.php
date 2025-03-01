<?php
function ListarInventario($conexion) {

    // Verificar si se ha enviado un valor para el filtro de tipo de producto
    $id_tipoprod = isset($_GET['id_tipoprod']) ? $_GET['id_tipoprod'] : '';


    $sql = "SELECT 
                p.id_prod AS IDPROD,
                p.producto AS PROD,
                p.modelo AS MODELO,
                m.marca AS MARCA,
                i.cantidad_v AS CANTIDADV,
                i.cantidad_c AS CANTIDADC,
                (i.cantidad_c - i.cantidad_v) AS STOCK,
                p.precio_compra AS PRECIOC,
                p.precio_venta AS PRECIOV
            FROM Producto p
            INNER JOIN Inventario i ON p.id_prod = i.id_prod
            INNER JOIN Marca m ON m.id_marca=p.id_marca";

    if ($id_tipoprod != '') {
        $sql .= " WHERE p.id_tipoprod = ?";
    }

    $stmt = $conexion->prepare($sql);

    if ($id_tipoprod != '') {
        $stmt->bind_param("i", $id_tipoprod);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    $inventario = [];
    while ($fila = $resultado->fetch_assoc()) {
        $inventario[] = $fila;
    }

    return $inventario;
}



?>