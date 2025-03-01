<?php
require_once 'funciones/conexion.php';
require_once 'funciones/login.php';
$MiConexion = ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/selectFPago.php';
require_once 'funciones/actualizarCompra.php';

$query = "SELECT id_proveedor, proveedor FROM proveedor"; 
$result = $MiConexion->query($query);

$ListadoProveedores = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ListadoProveedores[] = $row;
    }
}

require_once 'funciones/selectFPago.php';
$ListadoFP = ListarFPago($MiConexion);
$CantidadFP= count($ListadoFP);


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idCompra = $_GET['id'];

    $queryCompra = "SELECT *
                    FROM COMPRA c
                    WHERE c.id_compra = ?";
    $stmtCompra = $MiConexion->prepare($queryCompra);
    $stmtCompra->bind_param("i", $idCompra);
    $stmtCompra->execute();
    $resultCompra = $stmtCompra->get_result();
    $compra = $resultCompra->fetch_assoc();


    $stmtCompra->close();
} else {
    echo "ID de compra no especificado.";
    exit;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COMPRAS</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/sweetalert2.css">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
    <script src="js/material.min.js" ></script>
    <script src="js/sweetalert2.min.js" ></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js" ></script>
    <script src="js/main.js" ></script>
</head>
<body>
    <!-- Notifications area -->

    <!-- navLateral -->
<?php require_once 'inc/barralateral.inc.php';  ?>

    <!-- pageContent -->
    <section class="full-width pageContent">
        <!-- navBar -->
        <?php require_once 'inc/barranav.inc.php'; ?>
        
        <section class="full-width header-well">
            <div class="full-width header-well-icon">
                <i class="zmdi zmdi-shopping-cart-plus"></i>
            </div>
            <div class="full-width header-well-text">
                <p class="text-condensedLight">
                    COMPRA
                </p>
            </div>
        </section>
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
           
            <div class="mdl-tabs__panel is-active" id="tabNewProduct">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="full-width panel mdl-shadow--2dp">
                            <div class="full-width panel-tittle bg-primary text-center tittles">
                                Modificar compra
                            </div>
                            <div class="full-width panel-content">
<section>
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">

<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC    -  <b><a href=compra.php>Volver</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>

            <form role="form" method="POST">


<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
    <h5><strong class="text-condensedLight"><i class="zmdi zmdi-tag"></i> Número de Compra:</strong></h5>
    <label class="text-condensedLight" id="CompraID">
        <?php echo htmlspecialchars($idCompra); ?>
    </label>
    <input type="hidden" name="id_compra" value="<?php echo htmlspecialchars($idCompra); ?>">
</div>




                        <div class="mdl-card__actions mdl-card--border"></div>
                        <div class="mdl-card__actions mdl-card--border"></div>
                            
                            <div class="mdl-cell mdl-cell--4-col">
                       <h5><strong class="text-condensedLight"><i class="zmdi zmdi-shopping-cart-plus"></i> &nbsp; REGISTRAR NUEVOS PRODUCTOS </strong></h5><br>
                    <div ><a href="registrarProducto.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR PRODUCTOS</a></div>
                            </div>
<br>
<br>
<!-- ----------------------------------------------------- SELECCIONAR PROVEEDOR Y PRODUCTO ---------------------------- -->

<div class="mdl-card__actions mdl-card--border"></div>
<div class="mdl-card__actions mdl-card--border"></div>

                    <div class="mdl-cell mdl-cell--6-col">
                                        <label for="proveedorSelect"></label>
                                        <select class="mdl-textfield__input" id="proveedorSelect" name="proveedor">
                                            <option>Seleccionar Proveedor</option>
                                            <?php
                                            foreach ($ListadoProveedores as $proveedor) {
                                                echo "<option value='{$proveedor['id_proveedor']}'>{$proveedor['proveedor']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                   <div class="mdl-card__actions mdl-card--border"></div>

 <div class="mdl-cell mdl-cell--12-col">
   <h5> <strong class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; SELECCIONAR PRODUCTO/S</strong></h5>
</div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <label for="productoSelect"></label>
                                        <select class="mdl-textfield__input" id="productoSelect" name="id_prod">
                                            <option>Seleccionar Producto</option>
                                        </select>
                                    </div>

                                    <div class="mdl-cell mdl-cell--4-col">
                                        <label for="cantidadInput"><h6><strong>Cantidad:</strong></h6></label>
                                        <input type="number" id="cantidadInput" name="cantidad" min="1" value="1" class="mdl-textfield__input">
                                    </div>
                                    
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <button type="button" id="btnAgregarProducto" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                                           Agregar
                                        </button>
                                    </div>
                                    
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <table id="tablaProductos" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Modelo</th>
                                                    <th>Cantidad - Precio - Total</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
               <tbody>
                                                <!-- Aquí se agregarán las filas con productos seleccionados -->
                                            </tbody>
                                        </table>
<br>


                                  <div class="mdl-cell mdl-cell--12-col">
                                <h5><strong>Total de la Compra:</strong> $<span id="totalCompra">0.00</span></h5>
                                        </div><br>
                                        <br>
                                                                        <input type="hidden" name="detallesCompra" id="detallesCompraInput">



 <script>
        let detallesCompra = []; 
    let totalCompra = 0; 

    document.getElementById('btnAgregarProducto').addEventListener('click', function () {
        const productoSelect = document.getElementById('productoSelect');
        const productoId = productoSelect.value;
        const productoText = productoSelect.options[productoSelect.selectedIndex].text;
        const cantidad = parseInt(document.getElementById('cantidadInput').value, 10);
        const precioProducto = parseFloat(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio'));

        if (productoId && productoText !== 'Seleccionar Producto' && cantidad > 0 && !isNaN(precioProducto)) {
            const subtotal = cantidad * precioProducto;

            // Agregar a la tabla
            const tabla = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
            const nuevaFila = tabla.insertRow();
            nuevaFila.insertCell(0).textContent = productoText.split(' - ')[0]; // Nombre del producto
            nuevaFila.insertCell(1).textContent = productoText.split(' - ')[1]; // Modelo
            nuevaFila.insertCell(2).textContent = `${cantidad} x $${precioProducto.toFixed(2)} = $${subtotal.toFixed(2)}`;

            // Botón para eliminar
            const celdaEliminar = nuevaFila.insertCell(3);
            const btnEliminar = document.createElement('button');
            btnEliminar.classList.add('mdl-button');
            btnEliminar.innerHTML = '<i class="zmdi zmdi-delete"></i>';
            btnEliminar.addEventListener('click', function () {
                // Actualiza el total general
                totalCompra -= subtotal;
                document.getElementById('totalCompra').textContent = totalCompra.toFixed(2);
                // Elimina el producto del array
                detallesCompra = detallesCompra.filter(item => item.id_prod !== parseInt(productoId));
                // Elimina la fila de la tabla
                tabla.deleteRow(nuevaFila.rowIndex - 1);
            });
            celdaEliminar.appendChild(btnEliminar);

            // Actualiza el total
            totalCompra += subtotal;
            document.getElementById('totalCompra').textContent = totalCompra.toFixed(2);

            // Agregar a `detallesCompra`
            detallesCompra.push({
                id_prod: parseInt(productoId),
                cantprod: cantidad,
                totalcompra: subtotal
            });

            // Actualizar el input oculto
            document.getElementById('detallesCompraInput').value = JSON.stringify(detallesCompra);
        } else {
            alert('Por favor, selecciona un producto y cantidad válida.');
        }
    });

    // Cargar productos con precios en el selector de productos
    document.getElementById('proveedorSelect').addEventListener('change', function () {
        const proveedor = this.value;
        const productoSelect = document.getElementById('productoSelect');

        productoSelect.innerHTML = '<option>Seleccionar Producto</option>';

        if (proveedor) {
            fetch(`funciones/obtener_productos.php?proveedor=${encodeURIComponent(proveedor)}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.id_prod;
                        option.textContent = `${producto.producto} - ${producto.MODELO}`;
                        option.setAttribute('data-precio', producto.precio_compra); 
                        productoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar los productos:', error));
        }
    });

    </script>

<!-- ------------------------------------------------------------------------------------------------------------>
                
                 <div class="mdl-cell mdl-cell--8-col">
                <h5><strong class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; FORMA DE PAGO</strong></h5>
                </div>
                <div class="mdl-cell mdl-cell--4-col">
                <div class="mdl-textfield mdl-js-textfield">
                <select class="mdl-textfield__input" aria-label="Selector" id="selector" name="FPago">
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadFP ; $i++) {
           if (!empty($_POST['FPago']) && $_POST['FPago'] ==  $ListadoJer[$i]['IDFP']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoFP[$i]['IDFP']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoFP[$i]['PAGO']; ?>
            </option>
            <?php } ?>
            </select>     
            </div>
            </div>
                                        

                                        <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
                                            <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <h5><strong class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; INGRESAR FECHA</strong></h5>
                        <input class="mdl-textfield__input" type="date"  id="Fecha" name="Fecha" value="<?php echo !empty($_POST['Fecha']) ? $_POST['Fecha'] : ''; ?>">
                        </div>
                                    </div>
                                        </div>
                                       
                                        <br>

                                        <div class="mdl-card__actions mdl-card--border"></div>
                                        <div class="mdl-card__actions mdl-card--border"></div>
                                    
                                    <p class="text-center">


                                        <button type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addClient">
                                            <i class="zmdi zmdi-plus"></i>
                                        </button>
                                        <div class="mdl-tooltip" for="btn-addClient">Modificar Compra</div>
                                    </p>
                                </form>


                            </div>
                        
                            
                                </div>
                            </div>
                        </div>
                    </div>
                
        </div>

    </section>
</body>
</html>
