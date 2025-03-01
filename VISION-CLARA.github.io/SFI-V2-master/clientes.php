<?php
// 1. Incluir archivos y establecer conexión
require_once 'funciones/conexion.php';
$MiConexion = ConexionBD();
require_once 'funciones/autenticacion.php';
require_once 'funciones/selectprovincia.php';
$ListadoProvincia = ListarProvincia($MiConexion);
$CantidadProvincia = count($ListadoProvincia);
require_once 'verificacion.php';
require_once 'funciones/insertCliente.php'; 
require_once 'funciones/mostrarClientes.php';
require_once 'funciones/validardatos.php';

$mensajeC = "";
$mensajeE = "";
$ListadoCli = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {

        $resultado = InsertarCliente($MiConexion);
        $mensajeC = $resultado ? "Registro Exitoso." : "Error al intentar insertar el registro.";
        mysqli_close($MiConexion);
    } elseif (isset($_POST['buscar_dni'])) {

        $dni = trim($_POST['dni']);
        $stmt = $MiConexion->prepare("SELECT c.NOMBRE AS NOM_CLI, c.APELLIDO AS APE_CLI, c.DNI_CLI, c.Email AS MAIL_CLI, c.CIUDAD AS CIU_CLI, p.PROVINCIA_DESC AS PROVINCIA, c.CONTACTO AS CON_CLI
                               FROM cliente c, provincia p
                               WHERE p.ID_PROV = c.ID_PROV AND c.Disponibilidad = 1 AND c.DNI_CLI = ?");
        $stmt->bind_param("i", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        while ($fila = $resultado->fetch_assoc()) {
            $ListadoCli[] = $fila;
        }
        $stmt->close();
    }
} else {
    $ListadoCli = ListarClientes($MiConexion);
}

$CantidadCli = count($ListadoCli);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Clientes Listado</title>
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
				<i class="zmdi zmdi-accounts-list"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					CLIENTES
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListClient" class="mdl-tabs__tab is-active">EXISTENTES</a>
				<div class="panel-tittle text-center"><a href="registrarcliente.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR CLIENTE</a></div>
				
			</div>
		
			<div class="mdl-tabs__panel  is-active" id="tabListClient">
				<div class="mdl-grid">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Clientes Activos
							</div>
							<div class="full-width panel-content">

<!-- Formulario de búsqueda -->
  <form action="clientes.php" method="POST">
    <label for="dni">Buscar DNI: </label><i class="zmdi zmdi-search"></i>
    <input type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="dni" name="dni" required>
    <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" name="buscar_dni">Buscar</button>
  </form>
  <br>
  <table id="miTabla" cellpadding="100" cellspacing="100" border="3" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive-scroll">
    <thead>
      <tr class="color">
        <th onclick="sortTable(0, this)"><p class="text-center">NOMBRE</p></th>
        <th onclick="sortTable(1, this)"><p class="text-center">APELLIDO</p></th>
        <th onclick="sortTable(2, this)"><p class="text-center">DNI</p></th>
        <th onclick="sortTable(3, this)"><p class="text-center">EMAIL</p></th>
        <th onclick="sortTable(4, this)"><p class="text-center">CIUDAD</p></th>
        <th onclick="sortTable(5, this)"><p class="text-center">PROVINCIA</p></th>
        <th onclick="sortTable(6, this)"><p class="text-center">CONTACTO</p></th>
      </tr>
    </thead>
    <tbody>
      <?php 
      for ($i = 0; $i < $CantidadCli; $i++) { 
          
    if (!isset($ListadoCli[$i]['DISPO_CLI']) || $ListadoCli[$i]['DISPO_CLI'] != 0) {  
?>
      <tr>
        <td><?php echo $ListadoCli[$i]['NOM_CLI']; ?></td>
        <td><?php echo $ListadoCli[$i]['APE_CLI']; ?></td>
        <td><?php echo $ListadoCli[$i]['DNI_CLI']; ?></td>
        <td><?php echo $ListadoCli[$i]['MAIL_CLI']; ?></td>
        <td><?php echo $ListadoCli[$i]['CIU_CLI']; ?></td>
        <td><?php echo $ListadoCli[$i]['PROVINCIA']; ?></td>
        <td><?php echo $ListadoCli[$i]['CON_CLI']; ?></td>
      </tr>
<?php 
          } 
      } 
      ?>
    </tbody>
  </table>
								
				
<br>
<br>

<button onclick="window.open('Reportes/reporteClientes.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Generar reporte de clientes</button>
<br>
<br>
<br>

<!-- -------------------------------------BAJA------------------------------------------------ -->
<?php require_once 'funciones/bajaCLI.php';  ?>
				<div>
					<form action="" method="POST"> <input type="hidden" name="accion" value="dar_baja">

						<a><h5>Dar de baja un Cliente:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNI_CLI">
	<option>Seleccionar Cliente para BAJA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadCli; $i++) {
                 if ($ListadoCli[$i]['DISPO_CLI'] != 0) {
                 $selected = (!empty($_POST['DNI_CLI']) && $_POST['DNI_CLI'] == $ListadoCli[$i]['DNI_CLI']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoCli[$i]['DNI_CLI']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoCli[$i]['APE_CLI'] . ' , ' . $ListadoCli[$i]['NOM_CLI'] . ', DNI: ' . $ListadoCli[$i]['DNI_CLI'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit" name="BtnBaja" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"> Dar de baja</button>
					</form>
				<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC1)) {
    echo "<div class='mensaje-correcto'>$mensajeC1    -  <b><a href=clientes.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE1)) {
    echo "<div class='mensaje-alerta'>$mensajeE1</div>";
}
?>


<!-- -----------------------------------------ALTA-------------------------------------------- -->
<?php require_once'funciones/altaCLI.php';  ?>


<div>
<form action="" method="POST"> <input type="hidden" name="accion" value="dar_alta">

						<a><h5>Activar Cliente:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNI_CLI">
	<option>Seleccionar Cliente para ALTA</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadCli; $i++) {
                 if ($ListadoCli[$i]['DISPO_CLI'] != 1) {
                 $selected = (!empty($_POST['DNI_CLI']) && $_POST['DNI_CLI'] == $ListadoCli[$i]['DNI_CLI']) ? 'selected' : '';
                 ?>
                 <option value="<?php echo $ListadoCli[$i]['DNI_CLI']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoCli[$i]['APE_CLI'] . ' , ' . $ListadoCli[$i]['NOM_CLI'] . ', DNI:' . $ListadoCli[$i]['DNI_CLI'] . ''; ?>
                 </option>
                 <?php
                   }
                 }
                ?>
            </select>
            <br>
            <button type="submit"  name="BtnAlta" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Dar de alta</button>
				</form>
				</div>


<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC2)) {
    echo "<div class='mensaje-correcto'>$mensajeC2    -  <b><a href=clientes.php>Actualizar</a></b></div>";
    }

if (!empty($mensajeE2)) {
    echo "<div class='mensaje-alerta'>$mensajeE2</div>";
}
?>



<!-- ---------------------------------------MODIFICAR---------------------------------------------- -->

<div>
<form action="modificarCli.php" method="GET"> 

						<a><h5>Modificar Cliente:</h5></a>
<select class="mdl-textfield__input" aria-label="Selector" id="selector" name="DNI_CLI">
	<option>Seleccionar Cliente para MODIFICAR</option>
                          <?php 
            $selected='';

                 for ($i = 0; $i < $CantidadCli; $i++) {
                 if ($ListadoCli[$i]['DISPO_CLI'] != 0) {
              $selected = (!empty($_GET['DNI_CLI']) && $_GET['DNI_CLI'] == $ListadoCli[$i]['DNI_CLI']) ? 'selected' : '';?>
                 <option value="<?php echo $ListadoCli[$i]['DNI_CLI']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoCli[$i]['APE_CLI'] . ' , ' . $ListadoCli[$i]['NOM_CLI'] . ', DNI:' . $ListadoCli[$i]['DNI_CLI'] . ''; ?>
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

      if (n === 2 || n === 6 ) {
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