<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/insertPago.php';
require_once 'funciones/mostrarPago.php';

$ListadoTP = ListarPagos($MiConexion);
$CantidadTP = count($ListadoTP);

 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formas de Pago</title>
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
				<i class="zmdi zmdi-card"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					FORMAS DE PAGO
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,3,4, 5, 6,7))) { ?>
				<a href="#tabNewPayment" class="mdl-tabs__tab ">NUEVA</a>
				<?php } ?>

				<a href="#tabListPayment" class="mdl-tabs__tab is-active">LISTADO</a>
			</div>

			<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,3,4, 5, 6,7))) { ?>
			<div class="mdl-tabs__panel" id="tabNewPayment">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nueva forma de pago
							</div>
							<div class="full-width panel-content">
								<form role="form" method="POST">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DESCRIPCION DE PAGO</legend><br>
									    </div>
									   
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="T_PAGO" name="T_PAGO" value="<?php echo !empty($_POST['T_PAGO']) ? $_POST['T_PAGO'] : ''; ?>">
												<label class="mdl-textfield__label" for="descriptionPayment">DESCRIPCION</label>
												<span class="mdl-textfield__error">Invalid description</span>
											</div>
									    </div>
									</div>
									<p class="text-center">
										<button type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addPayment" >
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addPayment">AÑADIR FORMA DE PAGO</div>
									</p>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
<?php } ?>
		<!-- ---------------------------------------LISTA--------------------------------------------------------------------- -->	
			<div class="mdl-tabs__panel is-active" id="tabListPayment">
				<div class="mdl-grid">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Formas de Pago
							</div>
							<div class="full-width panel-content">

					<table cellpadding="100" cellspacing="100" border="3" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive" id="tabla">
							<tr  class="color">
								<td><p class="text-center">#</p></td>
								<td><p class="text-center">DESCRIPCION</p></td>
							</tr>
							<?php 

							for ($i = 0; $i < $CantidadTP; $i++) { ?>
						<?php	if ($ListadoTP[$i]['TP_PAGO'] != 0) {  ?>
										
								<tr>
									<td><b><?php echo ($i + 1); ?></b></td>
											<td ><?php echo $ListadoTP[$i]['TP_PAGO']; ?></td>

									</tr>
								<?php } ?>
								<?php } ?>

									</div>				
				</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>