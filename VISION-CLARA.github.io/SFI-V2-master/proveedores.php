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

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Proveedores Listado</title>
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
	    .active-header {
  background-color: #d0e6f8;
  color: #000; 
}
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
					PROVEEDORES
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListProvider" class="mdl-tabs__tab is-active">LISTA DE PROVEEDORES</a>
				<div class="panel-tittle text-center"><a href="registrarproveedor.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR PROVEEDOR</a></div>
			</div>

			
<!-- -------------------------------------------LISTA---------------------------------------- -->

			<div class="mdl-tabs__panel is-active" id="tabListProvider">

				<div class="mdl-grid">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Proveedores Activos
							</div>
							<div class="full-width panel-content">

					<table id="miTabla" cellpadding="100" cellspacing="100" border="3" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive-scroll">
						<thead>
							<tr class="color">
								<th onclick="sortTable(0, this)"><p class="text-center">NOMBRE</p></th>
								<th onclick="sortTable(1, this)"><p class="text-center">CUIT</p></th>
								<th onclick="sortTable(2, this)"><p class="text-center">CONTACTO</p></th>
								<th onclick="sortTable(3, this)"><p class="text-center">EMAIL</p></th>
								<th onclick="sortTable(4, this)"><p class="text-center">DOMICILIO</p></th>
								<th onclick="sortTable(5, this)"><p class="text-center">CIUDAD</p></th>
								<th onclick="sortTable(6, this)"><p class="text-center">PROVINCIA</p></th>
								
								
							</tr>
						</thead>
						<tbody>
							<?php 

							for ($i = 0; $i < $CantidadProv; $i++) { ?>
						<?php	if ($ListadoProv[$i]['DISPO_PROV'] != 0) {  ?>
										
								<tr>
											<td ><?php echo $ListadoProv[$i]['PROVEEDOR']; ?></td>
											<td ><?php echo $ListadoProv[$i]['ID_PROVE']; ?></td>
											<td ><?php echo $ListadoProv[$i]['CON_PROV']; ?></td>
											<td ><?php echo $ListadoProv[$i]['EMAIL_PROV']; ?></td>
											<td ><?php echo $ListadoProv[$i]['DOM_PROV']; ?></td>
											<td ><?php echo $ListadoProv[$i]['CIU_PROV']; ?></td>
											<td ><?php echo $ListadoProv[$i]['PROVINCIA']; ?></td>

									</tr>
								<?php } ?>
								<?php } ?>
</tbody>
									</div>				
				</table>
<br>
<br>
<button onclick="window.open('Reportes/reporteProveedores.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Generar reporte de Proveedores</button>
<br>
<br>

<!-- -------------------------------------BAJA------------------------------------------------ -->
<?php require_once 'funciones/bajaPROV.php'; ?>
				<div>
					<form action="" method="POST"> <input type="hidden" name="accion" value="dar_baja">

						<a><h5>Dar de baja un Proveedor:</h5></a>
<select class="form-select" aria-label="Selector" id="selector" name="ID_PROVE">
	<option>Seleccionar Proveedor para BAJA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadProv; $i++) {
                 if ($ListadoProv[$i]['DISPO_PROV'] != 0) {
                 $selected = (!empty($_POST['ID_PROVE']) && $_POST['ID_PROVE'] == $ListadoProv[$i]['ID_PROVE']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoProv[$i]['ID_PROVE']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoProv[$i]['PROVEEDOR'] . ', CUIT: ' . $ListadoProv[$i]['ID_PROVE'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="BtnBaja"> Dar de baja</button>
					</form>
				</div>
   <p> 
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC</div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?> </p>

<!-- -----------------------------------------ALTA-------------------------------------------- -->
<?php require_once'funciones/altaPROV.php';  ?>


<div>
<form action="" method="POST"> <input type="hidden" name="accion" value="dar_alta">

						<a><h5>Activar Proveedor:</h5></a>
<select class="form-select" aria-label="Selector" id="selector" name="ID_PROVE">
	<option>Seleccionar Proveedor para ALTA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadProv; $i++) {
                 if ($ListadoProv[$i]['DISPO_PROV'] != 1) {
                 $selected = (!empty($_POST['ID_PROVE']) && $_POST['ID_PROVE'] == $ListadoProv[$i]['ID_PROVE']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoProv[$i]['ID_PROVE']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoProv[$i]['PROVEEDOR'] . ', CUIT: ' . $ListadoProv[$i]['ID_PROVE'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"  name="BtnAlta">Dar de alta</button>
				</form>
				</div>


  <p>  <?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC2)) {
    echo "<div class='mensaje-correcto'>$mensajeC2</div>";
    }

if (!empty($mensajeE2)) {
    echo "<div class='mensaje-alerta'>$mensajeE2</div>";
}
?> </p>


<!-- ---------------------------------------MODIFICAR---------------------------------------------- -->

<div>
<form action="modificarProve.php" method="GET"> 

						<a><h5>Modificar Proveedor:</h5></a>
<select class="form-select" aria-label="Selector" id="selector" name="ID_PROVE">
	<option>Seleccionar Proveedor para MODIFICAR</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadProv; $i++) {
                 if ($ListadoProv[$i]['DISPO_PROV'] != 0) {
              $selected = (!empty($_GET['ID_PROVE']) && $_GET['ID_PROVE'] == $ListadoProv[$i]['ID_PROVE']) ? 'selected' : '';?>
                 <option value="<?php echo $ListadoProv[$i]['ID_PROVE']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoProv[$i]['PROVEEDOR'] . ', CUIT:' . $ListadoProv[$i]['ID_PROVE'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
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

      if (n === 1 || n === 2 ) {
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