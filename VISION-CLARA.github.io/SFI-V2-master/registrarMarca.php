<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/insertMarca.php';
require_once 'funciones/selectEstatus.php';

$ListadoE = ListarEstatus($MiConexion);
$CantidadE = count($ListadoE);

$resultado='';
$mensajeC='';
$mensajeE='';

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['BtnREG'])) {
 if ($_POST['accion'] === 'registro') {
    $resultado = InsertarMarca($MiConexion);
    if ($resultado) {
        $mensajeC= 'Marca registrada con éxito';
    } else {
        $mensajeE ='Error al registrar marca';
    }
}
}
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Marca</title>
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
				<i class="zmdi zmdi-label-heart"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					REGISTRAR MARCA
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			
			<div class="mdl-tabs__panel is-active" id="tabNewPayment">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nueva marca
							</div>
							<div class="full-width panel-content">
							
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC -  <b><a href=marcas.php>Volver</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?> 
								<form role="form" method="POST"> <input type="hidden" name="accion" value="registro">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DESCRIPCION DE MARCA</legend><br>
									    </div>
									   
									    <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet"><legend>CODIGO: codigo automatico</legend><BR>
											</div>


									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
									    	<legend><i class="zmdi zmdi-border-color"></i>MARCA:</legend>
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="MARCA" name="MARCA" value="<?php echo !empty($_POST['MARCA']) ? $_POST['MARCA'] : ''; ?>">
												<label class="mdl-textfield__label" for="descriptionPayment">Nombre</label>
											</div>
									    </div>
<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; ESTATUS </legend>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="ESTATUS">
													<option>Seleccionar estatus</option>
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadE ; $i++) {
           if (!empty($_POST['ESTATUS']) && $_POST['ESTATUS'] ==  $ListadoE[$i]['IDESTATUS']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoE[$i]['IDESTATUS']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoE[$i]['ESTATUS']; ?>
            </option>
            <?php } ?>
            </select>            
          	</div>
						</div>

										<br>
									<input type="hidden" name="Activo" value="1">

									<p class="text-center">
										<button type="submit" name="BtnREG" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary text-center" id="btn-addPayment" >
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addPayment">AÑADIR MARCA</div>
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