<?php  
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/login.php';
require_once 'funciones/autenticacion.php';


require_once 'funciones/mostrarProd_Stock.php';
$ListadoInventario = ListarInventario($MiConexion);
$CantidadItem = count($ListadoInventario);

require_once 'funciones/selectTipoProd.php';
$ListadoTipo = ListarTipoProd($MiConexion);
$CantidadTipo= count($ListadoTipo);

$id_tipoprod = isset($_GET['id_tipoprod']) ? $_GET['id_tipoprod'] : '';


?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventario</title>
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
				<i class="zmdi zmdi-store"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					INVENTARIO
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>

		<!-- Filtro por tipo de producto y stock -->
		 <div class="mdl-cell mdl-cell--6-col">
<form method="GET" action="inventory.php">
    <label for="tipoprod"><b>Filtrar por Tipo de Producto:</b></label>
    <select class="mdl-textfield__input" id="selector" name="id_tipoprod">
        <option value="">Seleccionar tipo de producto</option>
        <?php 
        $selected = '';
        for ($i = 0; $i < $CantidadTipo; $i++) {
            $selected = (!empty($_GET['id_tipoprod']) && $_GET['id_tipoprod'] == $ListadoTipo[$i]['IDTIPO']) ? 'selected' : '';
        ?>
            <option value="<?php echo $ListadoTipo[$i]['IDTIPO']; ?>" <?php echo $selected; ?>>
                <?php echo $ListadoTipo[$i]['TIPODESC']; ?>
            </option>
        <?php } ?>
    </select>
<button type="submit" id="btnFiltrarXprod" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Filtrar</button></form>
</div>

 <div class="mdl-cell mdl-cell--6-col">
<form method="GET" action="inventory.php">
    <label for="stock-filter"><b>Filtrar por Stock:</b></label>
    <select class="mdl-textfield__input" id="stock-filter" name="stock_level">
        <option value="">Seleccionar nivel de stock</option>
        <option value="alto" <?php echo (isset($_GET['stock_level']) && $_GET['stock_level'] == 'alto') ? 'selected' : ''; ?>>Stock Alto</option>
        <option value="medio" <?php echo (isset($_GET['stock_level']) && $_GET['stock_level'] == 'medio') ? 'selected' : ''; ?>>Stock Medio</option>
        <option value="bajo" <?php echo (isset($_GET['stock_level']) && $_GET['stock_level'] == 'bajo') ? 'selected' : ''; ?>>Stock Bajo</option>
        <option value="agotado" <?php echo (isset($_GET['stock_level']) && $_GET['stock_level'] == 'agotado') ? 'selected' : ''; ?>>Stock en 0</option>
    </select>
<button type="submit" id="btnFiltrarXstock" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Filtrar</button>
   
</form>
</div>

<br>
<br>

<form method="GET" action="Reportes/reporte.php" target="_blank">
    <input type="hidden" name="id_tipoprod" value="<?php echo isset($_GET['id_tipoprod']) ? $_GET['id_tipoprod'] : ''; ?>">
    <input type="hidden" name="stock_level" value="<?php echo isset($_GET['stock_level']) ? $_GET['stock_level'] : ''; ?>">
    <button type="submit" id="btnFiltrarXstock" name="generar_reporte" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Generar Reporte</button>
</form>

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
        <div class="table-responsive-scroll">
            <table id="miTabla" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
                <thead>
                    <tr>
                        <th onclick="sortTable(0, this)">STOCK</th>
                        <th onclick="sortTable(1, this)">PRODUCTO</th>
                        <th onclick="sortTable(2, this)">MODELO</th>
                        <th onclick="sortTable(3, this)">MARCA</th>
                        <th onclick="sortTable(4, this)">CODIGO PROD</th>
                        <th onclick="sortTable(5, this)">CANT. COMPRA</th>
                        <th onclick="sortTable(6, this)">CANT. VENTA</th>
                        <th onclick="sortTable(7, this)">PRECIO COMPRA</th>
                        <th onclick="sortTable(8, this)">PRECIO VENTA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($ListadoInventario as $item): 
   					 //color según el stock
   					 if ($item['STOCK'] <= 0) {
    				    $rowClass = 'stock-agotado';
    				    $stockCategory = 'agotado';
  					} elseif ($item['STOCK'] >= 150) {
  					    $rowClass = 'stock-alto';
    				    $stockCategory = 'alto';
    				} elseif ($item['STOCK'] >= 30) {
    				    $rowClass = 'stock-medio';
    				    $stockCategory = 'medio';
    				} else {
    				    $rowClass = 'stock-bajo';
    				    $stockCategory = 'bajo';
    				}

                        if (!empty($_GET['stock_level']) && $_GET['stock_level'] != $stockCategory) {
                            continue; 
                        }
                    ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td><?php echo $item['STOCK']; ?></td>
                            <td><?php echo $item['PROD']; ?></td>
                            <td><?php echo $item['MODELO']; ?></td>
                            <td><?php echo $item['MARCA']; ?></td>
                            <td><?php echo $item['IDPROD']; ?></td>
                            <td><?php echo $item['CANTIDADC']; ?></td>
                            <td><?php echo $item['CANTIDADV']; ?></td>
                            
                            <td><?php echo $item['PRECIOC']; ?></td>
                            <td><?php echo $item['PRECIOV']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

      if (n === 0 || n === 5 || n === 6 || n === 7 || n === 8) {
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