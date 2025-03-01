<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/insertPromo.php';
require_once 'funciones/selectPromo.php';

$ListadoP = ListarPromo($MiConexion);
$CantidadP = count($ListadoP);

$resultado='';
$mensajeC='';
$mensajeE='';

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['BtnREG'])) {
 if ($_POST['accion'] === 'registro') {
    $resultado = InsertarPromo($MiConexion);
    if ($resultado) {
        $mensajeC= 'Promoción insertada con éxito';
    } else {
        $mensajeE ='Error al insertar la promoción';
    }
}
}
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Promo</title>
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
				<i class="zmdi zmdi-favorite"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					REGISTRAR PROMO
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			
			<div class="mdl-tabs__panel is-active" id="tabNewPayment">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nueva promocion
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
								<form role="form" method="POST"> <input type="hidden" name="accion" value="registro">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DESCRIPCION DE PROMOCION</legend><br>
									    </div>
									   
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
									    	<legend>CODIGO PROMO:</legend><BR>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="CODPROMO" name="CODPROMO" value="<?php echo !empty($_POST['CODPROMO']) ? $_POST['CODPROMO'] : ''; ?>">
												<label class="mdl-textfield__label" for="descriptionPayment">CODIGO PROMO</label>
											</div>
									    </div>


									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
									    	<legend>PROMOCION:</legend><BR>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="PROMO" name="PROMO" value="<?php echo !empty($_POST['PROMO']) ? $_POST['PROMO'] : ''; ?>">
												<label class="mdl-textfield__label" for="descriptionPayment">PROMO nombre</label>
											</div>
									    </div>

									<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
										<legend>TERMINOS: </legend><BR>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<textarea class="mdl-textfield__input" type="textarea" id="TERM" name="TERM" value="<?php echo !empty($_POST['TERM']) ? $_POST['TERM'] : ''; ?>"></textarea>
												<label class="mdl-textfield__label" for="descriptionPayment">TERMINOS</label>
											</div>
									    </div>

									<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
										<legend>VALOR DESCUENTO: </legend><BR>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" id="DESC" name="DESC" value="<?php echo !empty($_POST['DESC']) ? $_POST['DESC'] : ''; ?>">
												<label class="mdl-textfield__label" for="descriptionPayment">DESCUENTO</label>
												<span class="mdl-textfield__error">Invalid description</span>
											</div>
									    </div>

									<input type="hidden" name="Activo" value="1">

									<p class="text-center">
										<button type="submit" name="BtnREG" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary text-center" id="btn-addPayment" >
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addPayment">AÑADIR PROMOCION</div>
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