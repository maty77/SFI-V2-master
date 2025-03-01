<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/insertMarca.php';
require_once 'funciones/selectMarca.php';

$ListadoM = ListarMarca($MiConexion);
$CantidadM = count($ListadoM);

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
	    .active-header {
  background-color: #d0e6f8; 
  color: #000; 
}
	.table-responsive-scroll {
  max-height: 400px;
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
					MARCAS
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListPayment" class="mdl-tabs__tab is-active">LISTADO</a>
				<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4,5,6))) { ?>
				<div class="panel-tittle text-center"><a href="registrarMarca.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR MARCA</a></div><?php } ?>
			</div>
			
<!---------------------------------------LISTA--------------------------------------------------------------------- -->	
			<div class="mdl-tabs__panel is-active" id="tabListPayment">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
							<div class="full-width panel-tittle bg-success text-center tittles">
								MARCAS ACTIVAS
							</div>
							<div class="table-responsive-scroll">
					<table id="miTabla" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
						<thead>
							<tr class="color">
								<td onclick="sortTable(0, this)"><p class="text-center">CODIGO</p></td>
								<td onclick="sortTable(1, this)"><p class="text-center">MARCA</p></td>
								<td onclick="sortTable(2, this)"><p class="text-center">ESTATUS</p></td>
							</tr>
						</thead>

							<tbody>
							<?php 

							for ($i = 0; $i < $CantidadM; $i++) { ?>
						<?php	if ($ListadoM[$i]['DISPO'] != 0) {  ?>

										
								<tr>
									<td ><?php echo $ListadoM[$i]['IDMARCA'];?></td>
									<td ><?php echo $ListadoM[$i]['MARCADESC']; ?></td>
									<td ><?php echo $ListadoM[$i]['ESTATUS']; ?></td>

									</tr>
								<?php } ?>
								<?php } ?>

									</tbody>			
				</table></div>
<br>
<br>
<button onclick="window.open('Reportes/reporteMarcas.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Ver reporte</button>
<br>
<br>

<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4,5,6))) { ?>
<?php require_once 'funciones/bajaMARCA.php'; ?>

				<div>
					<form action="" method="POST"> <input type="hidden" name="accion" value="dar_baja">

						<a><h5>Dar de baja una Marcas:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="IDMARCA">
	<option>Seleccionar Marca para BAJA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadM; $i++) {
                 if ($ListadoM[$i]['DISPO'] != 0) {
                 $selected = (!empty($_POST['IDMARCA']) && $_POST['IDMARCA'] == $ListadoM[$i]['IDMARCA']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoM[$i]['IDMARCA']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoM[$i]['MARCADESC'] . ', ' . $ListadoM[$i]['ESTATUS'] . ''; ?>
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
    echo "<div class='mensaje-correcto'>$mensajeC1    -  <b><a href=marcas.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE1)) {
    echo "<div class='mensaje-alerta'>$mensajeE1</div>";
}
?> 
						</div>
<!-- -----------------------------------------ALTA-------------------------------------------- -->
<?php require_once'funciones/altaMARCA.php';  ?>


<div>
<form action="" method="POST"> <input type="hidden" name="accion" value="dar_alta">

						<a><h5>Activar Marca:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="IDMARCA">
	<option>Seleccionar Marca para ALTA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadM; $i++) {
                 if ($ListadoM[$i]['DISPO'] != 1) {
                 $selected = (!empty($_POST['IDMARCA']) && $_POST['IDMARCA'] == $ListadoM[$i]['IDMARCA']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoM[$i]['IDMARCA']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoM[$i]['MARCADESC'] . ', ' . $ListadoM[$i]['ESTATUS'] . ''; ?>
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

<?php } ?>
  <?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC2)) {
    echo "<div class='mensaje-correcto'>$mensajeC2    -  <b><a href=marcas.php>Actualizar</a></b></div>";
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

      if (n === 0) {
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