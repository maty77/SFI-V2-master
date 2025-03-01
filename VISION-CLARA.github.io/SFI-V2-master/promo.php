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


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Promociones Listado</title>
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
					PROMOCIONES
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListPayment" class="mdl-tabs__tab is-active">LISTADO</a>
				<div class="panel-tittle text-center"><a href="registrarpromo.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR PROMO</a></div>
			</div>
			
<!---------------------------------------LISTA--------------------------------------------------------------------- -->	
			<div class="mdl-tabs__panel is-active" id="tabListPayment">
				<div class="mdl-grid">
							<div class="full-width panel-tittle bg-success text-center tittles">
								PROMOCIONES ACTIVAS
							</div>
							<div class="full-width panel-content">

					<table cellpadding="100" cellspacing="100" border="3" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive" id="tabla">
							<tr  class="color">
								<td><p class="text-center">#</p></td>
								<td><p class="text-center">Descripcion</p></td>
								<td><p class="text-center">Terminos</p></td>
								<td><p class="text-center">Codigo</p></td>
							</tr>
							<?php 

							for ($i = 0; $i < $CantidadP; $i++) { ?>
						<?php	if ($ListadoP[$i]['DISPO'] != 0) {  ?>

										
								<tr>
									<td><b><?php echo ($i); ?></b></td>
									<td ><?php echo $ListadoP[$i]['PROMO'].' % '.$ListadoP[$i]['VALOR'].''; ?></td>
									<td ><?php echo $ListadoP[$i]['TERMINOS']; ?></td>
									<td ><?php echo $ListadoP[$i]['IDPROMO']; ?></td>

									</tr>
								<?php } ?>
								<?php } ?>

									</div>				
				</table>
<br>
<br>
<button onclick="window.open('Reportes/reportePromociones.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Ver reporte</button>
<br>
<br>


<?php require_once 'funciones/bajaPROMO.php'; ?>

				<div>
					<form action="" method="POST"> <input type="hidden" name="accion" value="dar_baja">

						<a><h5>Dar de baja una Promocion:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="CODPROMO">
	<option>Seleccionar PROMOCION para BAJA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadP; $i++) {
                 if ($ListadoP[$i]['DISPO'] != 0) {
                 $selected = (!empty($_POST['CODPROMO']) && $_POST['CODPROMO'] == $ListadoP[$i]['IDPROMO']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoP[$i]['IDPROMO']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoP[$i]['PROMO'] . ', % ' . $ListadoP[$i]['VALOR'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="BtnBaja"> Dar de baja</button>
					</form>
				
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC1)) {
    echo "<div class='mensaje-correcto'>$mensajeC1    -  <b><a href=promo.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE1)) {
    echo "<div class='mensaje-alerta'>$mensajeE1</div>";
}
?> 
						</div>

<!-- -----------------------------------------ALTA-------------------------------------------- -->
<?php require_once'funciones/altaPROMO.php';  ?>


<div>
<form action="" method="POST"> <input type="hidden" name="accion" value="dar_alta">

						<a><h5>Activar Promocion:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="CODPROMO">
	<option>Seleccionar PROMOCION para ALTA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadP; $i++) {
                 if ($ListadoP[$i]['DISPO'] != 1) {
                 $selected = (!empty($_POST['CODPROMO']) && $_POST['CODPROMO'] == $ListadoP[$i]['IDPROMO']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoP[$i]['IDPROMO']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoP[$i]['PROMO'] . ', % ' . $ListadoP[$i]['VALOR'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="BtnAlta"> Dar de alta</button>
				</form>
				</div>


  <?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC2)) {
    echo "<div class='mensaje-correcto'>$mensajeC2    -  <b><a href=promo.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE2)) {
    echo "<div class='mensaje-alerta'>$mensajeE2</div>";
}
?> 


					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>