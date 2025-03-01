<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';

require_once 'verificacion.php';

require_once 'funciones/selectprovincia.php';
require_once 'funciones/insertProd.php'; 

require_once 'funciones/selectMarca.php';
$ListadoMarca = ListarMarca($MiConexion);
$CantidadMarca= count($ListadoMarca);

require_once 'funciones/selectProveedor.php';
$ListadoProv = ListarProve($MiConexion);
$CantidadProv= count($ListadoProv);

require_once 'funciones/selectTipoProd.php';
$ListadoTipo = ListarTipoProd($MiConexion);
$CantidadTipo= count($ListadoTipo);

require_once 'funciones/validardatos.php';
require_once 'funciones/actualizarProd.php';


$mensajeC='';
$mensajeE='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $MiConexion = ConexionBD();
    if ($_POST['accion'] === 'modificar') {
    	
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            
            $nombreArchivo = basename($_FILES['imagen']['name']);
            $rutaDestino = "assets/productos/" . $nombreArchivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
    $rutaImagen = $rutaDestino;
    $_POST['rutaImagen'] = $rutaImagen; 
} else {
    $mensajeE = "Error al mover el archivo.";
}
        } else {
            $mensajeE = "No se ha subido ninguna imagen o ha ocurrido un error.";
        }
        
         $resultado = ModificarProd($MiConexion, $_POST);

        if ($resultado) {
            $mensajeC = 'Modificacion Exitosa.';
        } else {
            $mensajeE = 'Error al intentar modificar el producto.';

        mysqli_close($MiConexion);
    }
}

}
$mensaje2='';
$mensaje='';

require_once 'funciones/productoPorId.php';

if (isset($_GET['id_prod'])) {
    $Id = $_GET['id_prod'];
   
    $producto = obtenerDatosProductoPorId($Id);

    $nombre = $producto['producto'] ?? '';
    $preciov = $producto['precio_venta'] ?? '';
    $precioc = $producto['precio_compra'] ?? '';
    $imagen = $producto['imagen'] ?? '';
    $modelo = $producto['modelo'] ?? '';
    $material = $producto['material'] ?? '';
    $descripcion = $producto['descripcion'] ?? '';
    $marca = $producto['marca'] ?? '';
    $proveedor = $producto['proveedor'] ?? '';
    $tpprod = $producto['tipoproducto_desc'] ?? '';
} else {
    echo "No se ha proporcionado un CODIGO válido.";
    exit;
}


 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modificar Producto</title>
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
				<i class="zmdi zmdi-accounts"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					PRODUCTO
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewClient" class="mdl-tabs__tab is-active">MODIFICAR</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewClient">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Modificar Producto
							</div>
							<div class="full-width panel-content">

<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC  -  <b><a href=productos.php>Volver a vista de productos</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>

	

			<form role="form" method="POST" enctype="multipart/form-data"> 
				<input type="hidden" name="accion" value="modificar" >

									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DATOS DE PRODUCTO</legend><br>
									    </div>
									    


									   <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9- ]*(\.[0-9]+)?" id="id_prod" name="id_prod" value="<?php echo htmlspecialchars($Id); ?>" readonly>
												<label class="mdl-textfield__label" for="BarCode">CODIGO DE PRODUCTO</label>
												<span class="mdl-textfield__error">Invalid barcode</span>
											</div>
										</div>
										

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="producto" name="producto" value="<?php echo htmlspecialchars($nombre); ?>">
												<label class="mdl-textfield__label" for="NameProduct">PRODUCTO</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
										</div>




										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9.]*(\.[0-9]+)?" id="precio_compra" name="precio_compra" value="<?php echo htmlspecialchars($precioc); ?>">
												<label class="mdl-textfield__label" for="PriceProduct">PRECIO COMPRA</label>
												<span class="mdl-textfield__error">Invalid price</span>
											</div>
										</div>


										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="precio_venta" name="precio_venta" value="<?php echo htmlspecialchars($preciov); ?>">
												<label class="mdl-textfield__label" for="discountProduct">PRECIO VENTA</label>
												<span class="mdl-textfield__error">Invalid discount</span>
											</div>	
										</div>


										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; PROVEEDOR </legend>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Id_Prove" >
													<option>Seleccionar Proveedor</option>
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadProv ; $i++) {
           if (!empty($_POST['Id_Prove']) && $_POST['Id_Prove'] ==  $ListadoProv[$i]['IDPROVE']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoProv[$i]['IDPROVE']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoProv[$i]['PROVEEDOR']; ?>
            </option>
            <?php } ?>
            </select>            
          	</div>
						</div>

										<br>

										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; MARCA </legend>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Id_Marca">
													<option>Seleccionar Marca</option>
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadMarca ; $i++) {
           if (!empty($_POST['Id_Marca']) && $_POST['Id_Marca'] ==  $ListadoMarca[$i]['IDMARCA']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoMarca[$i]['IDMARCA']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoMarca[$i]['MARCADESC']; ?>
            </option>
            <?php } ?>
            </select>            
          	</div>
						</div>

										<br>

										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; TIPO DE PRODUCTO</legend>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
													<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Id_tpprod">
													<option>Seleccionar tipo de producto</option>
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadTipo ; $i++) {
           if (!empty($_POST['Id_tpprod']) && $_POST['Id_tpprod'] ==  $ListadoTipo[$i]['IDTIPO']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoTipo[$i]['IDTIPO']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoTipo[$i]['TIPODESC']; ?>
            </option>
            <?php } ?>
            </select>            
          	</div>
						</div>


										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>">
												<label class="mdl-textfield__label" for="modelProduct">MODELO</label>
												<span class="mdl-textfield__error">Invalid model</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="material" name="material" value="<?php echo htmlspecialchars($material); ?>">
												<label class="mdl-textfield__label" for="markProduct">MATERIAL</label>
												<span class="mdl-textfield__error">Invalid Mark</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
												<label class="mdl-textfield__label" for="markProduct">DESCRIPCION EXTRA</label>
												<span class="mdl-textfield__error">Invalid Mark</span>
											</div>
										</div>

										<input type="hidden" name="Disponibilidad" value="1">

									
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield">
												<input type="file" id="imagen" name="imagen">
											</div>
										</div>
									</div>


									    
									</div>
									<p class="text-center">

										<button type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addClient">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addClient">Modificar Producto</div>
									</p>
								</form>


							</div>
						</div>
					</div>
				</div>

			</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>


	</section>
</body>
</html>