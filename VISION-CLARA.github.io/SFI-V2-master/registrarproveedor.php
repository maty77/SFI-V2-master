<?php  
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/selectprovincia.php';

$ListadoProvincia = ListarProvincia($MiConexion);
$CantidadProvincia= count($ListadoProvincia);

require_once 'funciones/insertProveedor.php'; 
require_once 'funciones/mostrarProveedor.php';

$ListadoProv = ListarProveedores($MiConexion);
$CantidadProv = count($ListadoProv);

require_once 'funciones/validardatos.php';

       $mensajeC = '';
        $mensajeE = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['accion'] === 'registrar') {
        $resultado = InsertarProveedor($MiConexion);
        if ($resultado) {
         $mensajeC = "Registro Exitoso";
		} else {
        $mensajeE = "Error al intentar insertar el registro";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Proveedor</title>
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
<style>
	.table-responsive-scroll {
  max-height: 700px; 
  overflow-y: auto; 
}
.color{
	background-color: #b6bdf8;
}
</style>
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
				<i class="zmdi zmdi-truck"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					REGISTRAR PROVEEDOR
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			
			<div class="mdl-tabs__panel is-active" id="tabNewProvider">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								NUEVO PROVEEDOR
							</div>
							<div class="full-width panel-content">
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC</div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?> 

<form role="form" method="POST" > <input type="hidden" name="accion" value="registrar">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DATA PROVIDER</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" id="CUIT" name="CUIT" value="<?php echo !empty($_POST['CUIT']) ? $_POST['CUIT'] : ''; ?>">
												<label class="mdl-textfield__label" for="CUIT">CUIT</label>
												<span class="mdl-textfield__error">Invalid number</span>
											</div>
									    </div>


									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="Proveedor" name="Proveedor" value="<?php echo !empty($_POST['Proveedor']) ? $_POST['Proveedor'] : ''; ?>">
												<label class="mdl-textfield__label" for="Proveedor">NOMBRE</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
									    </div>


									    <div class="mdl-cell mdl-cell--6-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="DomicilioProv" name="DomicilioProv" value="<?php echo !empty($_POST['DomiciolioProv']) ? $_POST['DomicilioProv'] : ''; ?>">
												<label class="mdl-textfield__label" for="DomicilioProv">DIRECCION</label>
												<span class="mdl-textfield__error">Invalid address</span>
											</div>
									    </div>


									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="CiudadProv" name="CiudadProv" value="<?php echo !empty($_POST['CiudadProv']) ? $_POST['CiudadProv'] : ''; ?>">
												<label class="mdl-textfield__label" >CIUDAD</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
									    </div>


				<div class="mdl-cell mdl-cell--12-col">
				<legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; PROVINCIA</legend>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-textfield mdl-js-textfield">
				<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Provincia">
					<option>Seleccionar provincia</option>
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadProvincia ; $i++) {
           if (!empty($_POST['Provincia']) && $_POST['Provincia'] ==  $ListadoProvincia[$i]['IDPROV']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoProvincia[$i]['IDPROV']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoProvincia[$i]['PROVINCIA']; ?>
            </option>
            <?php } ?>
            </select>            
          	</div>
						</div>

						<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" id="ContactoProv" name="ContactoProv" value="<?php echo !empty($_POST['ContactoProv']) ? $_POST['ContactoProv'] : ''; ?>">
												<label class="mdl-textfield__label" for="ContactoProv">CONTACTO</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
									    </div>


									    <input type="hidden" name="Disponibilidad" value="1">


									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="EmailProv" id="EmailProv" name="EmailProv" value="<?php echo !empty($_POST['EmialProv']) ? $_POST['EmailProv'] : ''; ?>">
												<label class="mdl-textfield__label" for="EmailProv">EMAIL</label>

												<span class="mdl-textfield__error">Invalid web address</span>
											</div>
									    </div>
									</div>


									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addProvider">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addProvider">Registrar Proveedor</div>
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


	</section>
</body>
</html>