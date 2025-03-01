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

$mensaje2='';
$mensaje='';

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administradores</title>
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
.color{
	background-color: #b6bdf8;
}
.active-header {
  background-color: #d0e6f8; 
  color: #000;
}
.table-responsive-scroll {
  max-height: 600px; 
  overflow-y: auto;
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
				<i class="zmdi zmdi-account"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					ADMINISTRADORES
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListClient" class="mdl-tabs__tab is-active">EXISTENTES</a>
				<div class="panel-tittle text-center"><a href="registraradmin.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR ADMINISTRADORES</a></div>
			</div>


<div class="mdl-tabs__panel is-active" id="tabListClient">
				<div class="mdl-grid">
					
							<div class="full-width panel-tittle bg-success text-center tittles">
								Administradores Activos
							</div>
							<div class="full-width panel-content">

					<table id="miTabla" cellpadding="100" cellspacing="100" border="3" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive-scroll">
							<thead>
							<tr class="color">
								<th onclick="sortTable(0, this)"><p class="text-center">JERARQUIA</p></th>
								<th onclick="sortTable(1, this)"><p class="text-center">NOMBRE</p></th>
								<th onclick="sortTable(2, this)"><p class="text-center">APELLIDO</p></th>
								<th onclick="sortTable(3, this)"><p class="text-center">DNI</p></th>
								<th onclick="sortTable(4, this)"><p class="text-center">USUARIO</p></th>
								<th onclick="sortTable(5, this)"><p class="text-center">CONTACTO</p></th>
                <th onclick="sortTable(5, this)"><p class="text-center">CONTRASÑA</p></th>

							</tr>
						</thead>
						<tbody>
							<?php 

							for ($i = 0; $i < $CantidadUsers; $i++) { ?>
						<?php	if ($ListadoUser[$i]['DISPO_U'] != 0) {  ?>
										
								<tr>
											<td ><?php echo $ListadoUser[$i]['JERARQUIA']; ?></td>
											<td ><?php echo $ListadoUser[$i]['NOM_U']; ?></td>
											<td ><?php echo $ListadoUser[$i]['APE_U']; ?></td>
											<td ><?php echo $ListadoUser[$i]['DNIuser']; ?></td>
											<td ><?php echo $ListadoUser[$i]['USER']; ?></td>
											<td ><?php echo $ListadoUser[$i]['CON_U']; ?></td>

                      <?php if ($_SESSION['Usuario_id_jer'] == 1 ) { ?>
                <td ><?php echo $ListadoUser[$i]['CONTRA']; ?></td>
                <?php } ?>

									</tr>
								<?php } ?>
								<?php } ?>

									</div>	
								</tbody>			
				</table>
<br>
<br>
<button onclick="window.open('Reportes/reporteAdmin.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Generar reporte de administradores</button>
<br>
<br>
<!-- -------------------------------------BAJA------------------------------------------------ -->
<?php require_once'funciones/bajaUSER.php';  ?>
				<div>
					<form action="" method="POST"> <input type="hidden" name="accion" value="dar_baja">

						<a><h5>Dar de baja un Administrador:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNI">
	<option>Seleccionar Administrador para BAJA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadUsers; $i++) {
                 if ($ListadoUser[$i]['DISPO_U'] != 0) {
                 $selected = (!empty($_POST['DNIadmin']) && $_POST['DNIadmin'] == $ListadoUser[$i]['DNIuser']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoUser[$i]['DNIuser']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoUser[$i]['APE_U'] . ' , ' . $ListadoUser[$i]['NOM_U'] . ', DNI: ' . $ListadoUser[$i]['DNIuser'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" name="BtnBaja" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"> Dar de baja</button>
					</form>
				</div>
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC    -  <b><a href=admin.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>


<!-- -----------------------------------------ALTA-------------------------------------------- -->
<?php require_once'funciones/altaUSER.php';  ?>


<div>
<form action="" method="POST"> <input type="hidden" name="accion" value="dar_alta">

						<a><h5>Activar Administrador:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNI">
	<option>Seleccionar Administrador para ALTA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadUsers; $i++) {
                 if ($ListadoUser[$i]['DISPO_U'] != 1) {
                 $selected = (!empty($_POST['DNIadmin']) && $_POST['DNIadmin'] == $ListadoUser[$i]['DNIuser']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoUser[$i]['DNIuser']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoUser[$i]['APE_U'] . ' , ' . $ListadoUser[$i]['NOM_U'] . ', DNI:' . $ListadoUser[$i]['DNIuser'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" name="BtnAlta" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Dar de alta</button>
				</form>
				</div>

<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC2)) {
    echo "<div class='mensaje-correcto'>$mensajeC2    -  <b><a href=admin.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE2)) {
    echo "<div class='mensaje-alerta'>$mensajeE2</div>";
}
?>
<!-- ---------------------------------------MODIFICAR---------------------------------------------- -->

<div>
<form action="modificarAdmin.php" method="GET"> 

						<a><h5>Modificar Administrador:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNIadmin">
	<option>Seleccionar Administrador para MODIFICAR</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadUsers; $i++) {
                 if ($ListadoUser[$i]['DISPO_U'] != 0) {
              $selected = (!empty($_GET['DNIadmin']) && $_GET['DNIadmin'] == $ListadoUser[$i]['DNIuser']) ? 'selected' : '';?>
                 <option value="<?php echo $ListadoUser[$i]['DNIuser']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoUser[$i]['APE_U'] . ' , ' . $ListadoUser[$i]['NOM_U'] . ', DNI:' . $ListadoUser[$i]['DNIuser'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Modificar</button>
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
<script>
 function sortTable(n, thElement) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("miTabla");
  
  // Eliminar la clase "active-header" de todos los encabezados
  var headers = table.getElementsByTagName("th");
  for (var j = 0; j < headers.length; j++) {
    headers[j].classList.remove("active-header");
  }
  // Agregar la clase al encabezado seleccionado
  thElement.classList.add("active-header");

  switching = true;
  // Dirección inicial: ascendente
  dir = "asc";
  
  while (switching) {
    switching = false;
    // Obtener las filas del <tbody>
    rows = table.getElementsByTagName("tbody")[0].rows;
    
    for (i = 0; i < rows.length - 1; i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("td")[n];
      y = rows[i + 1].getElementsByTagName("td")[n];

      if (n === 3 || n === 5 ) {
        var numX = parseFloat(x.innerHTML) || 0;
        var numY = parseFloat(y.innerHTML) || 0;
        if (dir === "asc") {
          if (numX > numY) {
            shouldSwitch = true;
            break;
          }
        } else if (dir === "desc") {
          if (numX < numY) {
            shouldSwitch = true;
            break;
          }
        }
      } else {
        // Comparación para columnas de texto
        if (dir === "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        } else if (dir === "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        }
      }
    }
    
    if (shouldSwitch) {
      // Intercambiar filas
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount++;
    } else {
      // Si no se realizaron cambios y la dirección era ascendente, invertir a descendente
      if (switchcount === 0 && dir === "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}   
</script>