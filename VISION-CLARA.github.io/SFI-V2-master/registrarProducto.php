<?php  
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/selectMarca.php';
$ListadoMarca = ListarMarca($MiConexion);
$CantidadMarca= count($ListadoMarca);

require_once 'funciones/selectProveedor.php';
$ListadoProv = ListarProve($MiConexion);
$CantidadProv= count($ListadoProv);

require_once 'funciones/selectTipoProd.php';
$ListadoTipo = ListarTipoProd($MiConexion);
$CantidadTipo= count($ListadoTipo);

require_once 'funciones/mostrarproducto.php';
$ListadoProd = ListarProd($MiConexion);
$CantidadProd= count($ListadoProd);


$query = "SELECT DISTINCT marca FROM marca"; 
$result = $conexion->query($query);

$ListadoMarcas = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ListadoMarcas[] = $row['marca'];
    }
}

require_once 'funciones/insertProd.php';
require_once 'funciones/registrarPROD.php';
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Producto</title>
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
					REGISTRO DE PRODUCTO
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			
			<div class="mdl-tabs__panel is-active" id="tabNewProduct">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nuevo Producto
							</div>
							<div class="full-width panel-content">


<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC  -  <b><a href=registrarProducto.php>Registrar otro producto</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>


								<form role="form" method="POST" enctype="multipart/form-data"> 
									<input type="hidden" name="accion" value="registrar" >

									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; INFORMACION </legend><br>
									    </div>
										
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9- ]*(\.[0-9]+)?" id="Id_Prod" name="Id_Prod" value="<?php echo !empty($_POST['Id_Prod']) ? $_POST['Id_Prod'] : ''; ?>">
												<label class="mdl-textfield__label" for="BarCode">CODIGO DE PRODUCTO</label>
												<span class="mdl-textfield__error">Invalid barcode</span>
											</div>
										</div>
										

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NombreProd" name="NombreProd" value="<?php echo !empty($_POST['NombreProd']) ? $_POST['NombreProd'] : ''; ?>">
												<label class="mdl-textfield__label" for="NameProduct">PRODUCTO</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
										</div>


										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9.]*(\.[0-9]+)?" id="Precio_C" name="Precio_C" value="<?php echo !empty($_POST['Precio_C']) ? $_POST['Precio_C'] : ''; ?>">
												<label class="mdl-textfield__label" for="PriceProduct">PRECIO COMPRA</label>
												<span class="mdl-textfield__error">Invalid price</span>
											</div>
										</div>


										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="Precio_V" name="Precio_V" value="<?php echo !empty($_POST['Precio_V']) ? $_POST['Precio_V'] : ''; ?>">
												<label class="mdl-textfield__label" for="discountProduct">PRECIO VENTA</label>
												<span class="mdl-textfield__error">Invalid discount</span>
											</div>	
										</div>


										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; PROVEEDOR </legend>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Id_Prove">
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
												<input class="mdl-textfield__input" type="text" id="Modelo" name="Modelo" value="<?php echo !empty($_POST['Modelo']) ? $_POST['Modelo'] : ''; ?>">
												<label class="mdl-textfield__label" for="modelProduct">MODELO</label>
												<span class="mdl-textfield__error">Invalid model</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="Material" name="Material" value="<?php echo !empty($_POST['Material']) ? $_POST['Material'] : ''; ?>">
												<label class="mdl-textfield__label" for="markProduct">MATERIAL</label>
												<span class="mdl-textfield__error">Invalid Mark</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="Descripcion" name="Descripcion" value="<?php echo !empty($_POST['Descripcion']) ? $_POST['Descripcion'] : ''; ?>">
												<label class="mdl-textfield__label" for="markProduct">DESCRIPCION EXTRA</label>
												<span class="mdl-textfield__error">Invalid Mark</span>
											</div>
										</div>

										<input type="hidden" name="Disponibilidad" value="1">

									
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield">
												<input type="file" id="Imagen" name="Imagen">
											</div>
										</div>
									</div>


									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addProduct">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addProduct">Registrar Producto</div>
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