<?php 
require_once 'conexion.php';
$conexion = ConexionBD();

$mensajeE = ''; 
$mensajeC = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // VALIDACIÓN DEL DNI DEL CLIENTE
    $dni_cliente = $_POST['DNI'] ?? null;
    $queryCheckDNI = "SELECT COUNT(*) AS existe FROM cliente WHERE DNI_CLI = ?";
    $stmtCheck = $conexion->prepare($queryCheckDNI);
    $stmtCheck->bind_param('s', $dni_cliente);
    $stmtCheck->execute();
    $resultado = $stmtCheck->get_result()->fetch_assoc();
    if ($resultado['existe'] == 0) {
        echo "<script>alert('El DNI ingresado no existe en la base de datos. VENTA NO REGISTRADA.');</script>";
        exit;
    }

    try {
        // INICIAR TRANSACCIÓN
        $conexion->begin_transaction();

        // REGISTRO DE LA VENTA
        $id_venta        = $_POST['id_venta'] ?? null;
        $usuario_sesion  = $_POST['DNI_U'] ?? null;
        $id_cob          = $_POST['id_cob'] ?? null;
        $id_promo        = $_POST['id_promo'] ?? null;
        $id_pago         = $_POST['id_pago'] ?? null;
        $id_entrega      = $_POST['id_entrega'] ?? null;
        $detallesVenta   = isset($_POST['detallesVenta']) ? json_decode($_POST['detallesVenta'], true) : [];
        $fechaHoraVenta  = $_POST['fecha_hora_venta'] ?? date('Y-m-d H:i:s');
        $total_input     = $_POST['total_input'] ?? 0;

        $queryVenta = "INSERT INTO venta (id_venta, DNI_U, DNI_CLI, id_promo, id_pago, id_ent, id_cob, fecha, total)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtVenta = $conexion->prepare($queryVenta);
        $stmtVenta->bind_param('iisiiiisd', $id_venta, $usuario_sesion, $dni_cliente, $id_promo, $id_pago, $id_entrega, $id_cob, $fechaHoraVenta, $total_input);

        if (!$stmtVenta->execute()) {
            throw new Exception("Error al registrar la venta: " . $stmtVenta->error);
        }
        $stmtVenta->close();

        // REGISTRO DE LOS DETALLES DE LA VENTA Y ACTUALIZACIÓN DEL INVENTARIO
        $stmtDetalle = $conexion->prepare("INSERT INTO detalleventa (id_venta, id_prod, cantprod, totalventa) VALUES (?, ?, ?, ?)");
        $stmtInventario = $conexion->prepare("UPDATE Inventario SET cantidad_v = cantidad_v + ? WHERE id_prod = ?");

        foreach ($detallesVenta as $detalle) {
            $idProducto = (int) $detalle['id_prod'];
            $cantidad   = (int) $detalle['cantprod'];
            $totalprod  = (float) $detalle['subtotal'];

            $stmtDetalle->bind_param("iiid", $id_venta, $idProducto, $cantidad, $totalprod);
            if (!$stmtDetalle->execute()) {
                throw new Exception("Error en detalle de venta: " . $stmtDetalle->error);
            }

            $stmtInventario->bind_param("ii", $cantidad, $idProducto);
            if (!$stmtInventario->execute()) {
                throw new Exception("Error en inventario: " . $stmtInventario->error);
            }
        }
        $stmtDetalle->close();
        $stmtInventario->close();
        
        // REGISTRO DE LOS REGISTROS OFTALMOLÓGICOS
        
        $id_monturas = $_POST['id_montura'];      
        $numRecetas = isset($_POST['num_recetas']) ? (int)$_POST['num_recetas'] : 0;
        $id_cristales = $_POST['id_cristal'];      
        $indices = $_POST['IND_REF'];               
        $tratamientosArr = $_POST['tratamientos'];  
        $derRadios = $_POST['Der'];                 
        $izqRadios = $_POST['Izq'];                 
        $archivos = $_FILES['receta'];              

        for ($i = 0; $i < $numRecetas; $i++) {
            $fecha = date('Y-m-d');
            $id_cristal = isset($id_cristales[$i]) ? $id_cristales[$i] : null;
            $indice_refraccion = isset($indices[$i]) ? $indices[$i] : null;
            
            $tratamientos = isset($tratamientosArr[$i+1]) ? $tratamientosArr[$i+1] : [];
            
            $indice = $i + 1;
            $ojo_der_esf = (isset($derRadios[$indice]) && $derRadios[$indice] === "Esferico") ? "SI" : "NO";
            $ojo_der_cil = (isset($derRadios[$indice]) && $derRadios[$indice] === "Cilindro") ? "SI" : "NO";
            $ojo_izq_esf = (isset($izqRadios[$indice]) && $izqRadios[$indice] === "Esferico") ? "SI" : "NO";
            $ojo_izq_cil = (isset($izqRadios[$indice]) && $izqRadios[$indice] === "Cilindro") ? "SI" : "NO";
            
            $archivo_receta = null;
            if (isset($archivos['error'][$i]) && $archivos['error'][$i] === UPLOAD_ERR_OK) {
                $nombreOriginal = $archivos['name'][$i];
                $tmpName = $archivos['tmp_name'][$i];
                $destino = __DIR__ . "/uploads/" . time() . "_" . basename($nombreOriginal);
                if (move_uploaded_file($tmpName, $destino)) {
                    $archivo_receta = $destino;
                }
            }
            
            $sqlReceta = "INSERT INTO Receta (fecha, id_cristal, ojo_der_esf, ojo_der_cil, ojo_izq_esf, ojo_izq_cil, indice_refraccion, archivo_receta)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtReceta = $conexion->prepare($sqlReceta);
            if (!$stmtReceta) {
                throw new Exception("Error al preparar consulta de receta: " . $conexion->error);
            }
            $stmtReceta->bind_param("ssssssss", $fecha, $id_cristal, $ojo_der_esf, $ojo_der_cil, $ojo_izq_esf, $ojo_izq_cil, $indice_refraccion, $archivo_receta);
            if (!$stmtReceta->execute()) {
                throw new Exception("Error al insertar registro oftalmológico en la receta " . ($i+1) . ": " . $stmtReceta->error);
            }
            // Obtener el id_receta generado
            $id_receta = $conexion->insert_id;
            $stmtReceta->close();
            
            // Insertar la relación de tratamientos en la tabla intermedia "receta_tratamientos"
            if (!empty($tratamientos)) {
                foreach ($tratamientos as $id_trat) {
                    $sqlRel = "INSERT INTO receta_tratamientos (id_receta, id_trat) VALUES (?, ?)";
                    $stmtRel = $conexion->prepare($sqlRel);
                    if (!$stmtRel) {
                        throw new Exception("Error al preparar la inserción en receta_tratamientos: " . $conexion->error);
                    }
                    $stmtRel->bind_param("ii", $id_receta, $id_trat);
                    if (!$stmtRel->execute()) {
                        throw new Exception("Error al insertar en receta_tratamientos para receta " . ($i+1) . ": " . $stmtRel->error);
                    }
                    $stmtRel->close();
                }
            }
            
            // Insertar en venta_receta
            $id_monturas = $_POST['id_montura']; 
            $monturaSeleccionada = isset($id_monturas[$i]) ? $id_monturas[$i] : null;
            if (!empty($monturaSeleccionada)) {
                $sqlVentaReceta = "INSERT INTO venta_receta (id_venta, id_prod, id_receta) VALUES (?, ?, ?)";
                $stmtVentaReceta = $conexion->prepare($sqlVentaReceta);
                if (!$stmtVentaReceta) {
                    throw new Exception("Error al preparar la inserción en venta_receta: " . $conexion->error);
                }
                $stmtVentaReceta->bind_param("iii", $id_venta, $monturaSeleccionada, $id_receta);
                if (!$stmtVentaReceta->execute()) {
                    throw new Exception("Error al insertar en venta_receta para la receta " . ($i+1) . ": " . $stmtVentaReceta->error);
                }
                $stmtVentaReceta->close();
            }
        } 
        
        // Confirmar la transacción
        $conexion->commit();
        echo "<script>window.open('Reportes/factura_comprobante_venta.php?id_venta=" . $id_venta . "', '_blank');</script>";
        $mensajeC = "Venta realizada con éxito.";
    } catch (Exception $e) {
        $conexion->rollback();
        $mensajeE = "Error al registrar la venta: " . $e->getMessage();
    }
} 
?>