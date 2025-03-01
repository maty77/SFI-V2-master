<?php 
require_once 'funciones/conexion.php';

$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';

require_once 'funciones/selectprovincia.php';
$ListadoProvincia = ListarProvincia($MiConexion);
$CantidadProvincia= count($ListadoProvincia);

require_once 'funciones/selectJerarquia.php';
$ListadoJer = ListarJerarquia($MiConexion);
$CantidadJer= count($ListadoJer);


require_once 'verificacion.php';

require_once 'funciones/insertAdmin.php'; 
require_once 'funciones/mostrarAdmin.php';

$ListadoUser = ListarAdmin($MiConexion);
$CantidadUsers = count($ListadoUser);

require_once 'funciones/validardatos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $MiConexion = ConexionBD();
    if ($_POST['accion'] === 'registrarAD') {

        $mensajeCR = '';
        $mensajeER = '';

        $resultado = InsertarAdmin($MiConexion);
         $mensajeCR = "Registro exitoso.";

        if (!$resultado) {
            $mensajeER = "Error al intentar insertar el registro.";
        }
        
        mysqli_close($MiConexion);
    }
}

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Administradores</title>
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
				<i class="zmdi zmdi-account"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					REGISTRO DE ADMINISTRADORES
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			
			<div class="mdl-tabs__panel is-active" id="tabNewClient">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nuevo Administrador
							</div>
							<div class="full-width panel-content">
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeCR)) {
    echo "<div class='mensaje-correcto'>$mensajeCR    -  <b><a href=admin.php>Volver</a></b></div>";
    }

if (!empty($mensajeER)) {
    echo "<div class='mensaje-alerta'>$mensajeER</div>";
}
?>

			<form role="form" method="POST" > <input type="hidden" name="accion" value="registrarAD">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DATOS DEL USUARIO</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" name="DNIadmin" id="DNIadmin" value="<?php echo !empty($_POST['DNIadmin']) ? $_POST['DNIadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="DNIAdmin">DNI</label>
												<span class="mdl-textfield__error">DNI invalido</span>
											</div>
									    </div>
									    
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="NOMadmin" id="NOMadmin" value="<?php echo !empty($_POST['NOMadmin']) ? $_POST['NOMadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="NameAdmin">Nombre</label>
												<span class="mdl-textfield__error">Nombre invalido</span>
											</div>
									    </div>
										
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="APEadmin" id="APEadmin" value="<?php echo !empty($_POST['APEadmin']) ? $_POST['APEadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="LastNameAdmin">Apellido</label>
												<span class="mdl-textfield__error">Apellido invalido</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="DOMadmin" id="DOMadmin" value="<?php echo !empty($_POST['DOMadmin']) ? $_POST['DOMadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="LastNameAdmin">Domicilio</label>
												<span class="mdl-textfield__error">Domicilio invalido</span>
											</div>
										</div>

										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" name="CIUadmin" id="CIUadmin" value="<?php echo !empty($_POST['CIUadmin']) ? $_POST['CIUadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="LastNameAdmin">Ciudad</label>
												<span class="mdl-textfield__error">Ciudad invalido</span>
											</div>
										</div>


				<div class="mdl-cell mdl-cell--12-col">
				<legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; PROVINCIA</legend>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-textfield mdl-js-textfield">
				<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Provincia">
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
            </select>            </div>
						</div>


										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" name="CONTadmin" id="CONTadmin" value="<?php echo !empty($_POST['CONTadmin']) ? $_POST['CONTadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="phoneAdmin">Contacto</label>
												<span class="mdl-textfield__error">Contacto invalido</span>
											</div>
										</div>
									

										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; DATOS DE CUENTA</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" name="EMAILadmin" id="EMAILadmin" value="<?php echo !empty($_POST['EMAILadmin']) ? $_POST['EMAILadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="UserNameAdmin">Email</label>
												<span class="mdl-textfield__error">Email invalido</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="password" name="PASSadmin" id="PASSadmin" value="<?php echo !empty($_POST['PASSadmin']) ? $_POST['PASSadmin'] : ''; ?>">
												<label class="mdl-textfield__label" for="passwordAdmin">Contraseña</label>
												<span class="mdl-textfield__error">Contraseña invalida</span>
											</div>
										</div>
										
										 <div class="mdl-cell mdl-cell--8-col">
				<legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; JERARQUIA</legend>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-textfield mdl-js-textfield">
				<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="Jerarquia">
                          <?php 
            $selected='';
           for ($i=0 ; $i < $CantidadJer ; $i++) {
           if (!empty($_POST['Jerarquia']) && $_POST['Jerarquia'] ==  $ListadoJer[$i]['IDJER']) {
            $selected = 'selected';
            }else {
            $selected='';
            }
            ?>
            <option value="<?php echo $ListadoJer[$i]['IDJER']; ?>" <?php echo $selected; ?>  >
            <?php echo $ListadoJer[$i]['JERARQUIA']; ?>
            </option>
            <?php } ?>
            </select>            
        	</div>
			</div>
 									   <input type="hidden" name="Disponibilidad" value="1">
											    
										</div>	
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addAdmin">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addAdmin">Registrar Administrador</div>
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
				

	</section>
</body>
</html>