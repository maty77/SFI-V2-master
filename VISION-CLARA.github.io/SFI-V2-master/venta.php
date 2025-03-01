<?php  
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/login.php';
require_once 'funciones/autenticacion.php';


require_once 'funciones/mostrarVenta.php';
$ListadoVen = ListarVenta($MiConexion);
$CantidadVen = count($ListadoVen);


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VENTAS</title>
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
				<i class="zmdi zmdi-local-mall"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					LISTADO DE VENTAS
				</p>
			</div>
		</section>

		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabList" class="mdl-tabs__tab is-active">LISTADO</a>

			</div>

		<div class="full-width divider-menu-h"></div>



					<div class="mdl-tabs__panel is-active" id="tabList"> <!-- ---- -->

<?php if ($_SESSION['Usuario_id_jer'] != 2 ) { ?>
<form action="Reportes/reporte_gral_ventas.php" method="GET" target="_blank">
    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
        <h5><strong class="text-condensedLight"><i class="zmdi zmdi-assignment"></i> &nbsp; GENERAR REPORTE</strong></h5>

        <strong>Fecha desde:</strong>
        <input type="date" name="fecha_desde" required>

        <strong>Fecha hasta:</strong>
        <input type="date" name="fecha_hasta" required>

        <div>
            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">GENERAR</button>
        </div>
    </div>
</form>
<?php } ?>

<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
			<h5> <strong class="text-condensedLight"><i class="zmdi zmdi-view-list-alt"></i> &nbsp; LISTADO DE VENTAS</strong></h5>
				<div class="table-responsive-scroll">
					<table id="miTabla" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
						<thead>
						<tr>
								<th onclick="sortTable(0, this)"><b>FECHA</b></th>
								<th onclick="sortTable(1, this)"><b>N° VENTA</b></th>
								<th onclick="sortTable(2, this)"><b>TOTAL VENTA</b></th>
								<th onclick="sortTable(3, this)"><b>VENDEDOR</b></th>
								<th onclick="sortTable(4, this)"><b>FORMA DE PAGO</b></th>
								<th onclick="sortTable(5, this)"><b>ENTREGA</b></th>
								<th><b>ACCION</b></td>
							</tr>
						</thead>
							<?php 

							for ($i = 0; $i < $CantidadVen; $i++) { ?>
										
								<tr>
									<td ><?php echo date("d-m-Y H:i", strtotime($ListadoVen[$i]['FECHA'])); ?></td>
									<td ><?php echo $ListadoVen[$i]['ID_VENTA']; ?></td>
									<td ><?php echo $ListadoVen[$i]['TOTALV']; ?></td>
									<td ><?php echo $ListadoVen[$i]['USER']; ?></td>
									<td ><?php echo $ListadoVen[$i]['TPAGO']; ?></td>
									<td ><?php echo $ListadoVen[$i]['ENTREGA']; ?></td>
<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect imprimir-btn" data-id="<?php echo $ListadoVen[$i]['ID_VENTA']; ?>">
    <i class="zmdi zmdi-print"></i>
</button>
												
	<div class="mdl-tooltip" for="Imprimir">Imprimir</div>

									</td>
									</tr>
								<?php } ?>

									</div>				
							
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> 

	<!-- ------------------------------------ REGISTRAR NUEVA COMPRA ---------------------------------------- -->



			</div>


	</section>
</body>
</html>

<script>
	 document.addEventListener("DOMContentLoaded", function () {
        const imprimirBotones = document.querySelectorAll(".imprimir-btn");

        imprimirBotones.forEach(boton => {
            boton.addEventListener("click", function () {
                const idVenta = this.dataset.id;
                if (idVenta) {
                    window.open(`Reportes/reporte_x_venta.php?id=${idVenta}`, "_blank");
                }
            });
        });
    });
 document.addEventListener("DOMContentLoaded", function () {
        const editarBotones = document.querySelectorAll(".editar-btn");

        editarBotones.forEach(boton => {
            boton.addEventListener("click", function () {
                const idCompra = this.dataset.id;
                if (idCompra) {
                    window.location.href = `modificarCompra.php?id=${idCompra}`;
                }
            });
        });
    });


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

      // Comparación especial para la columna TOTAL (índice 3) con valores numéricos
      if (n === 2 || n === 1 || n === 3) {
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