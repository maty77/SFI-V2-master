<?php
session_start();
require_once 'productosController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Productos</title>
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
				<i class="zmdi zmdi-shopping-cart-plus"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					PRODUCTOS
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabListProducts" class="mdl-tabs__tab is-active">LISTADO ACTUAL</a>
<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4,5,6))) { ?>
                <div class="panel-tittle text-center"><a href="registrarProducto.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">NUEVO PRODUCTO   </a></div>

				<div class="panel-tittle text-center"><a href="ProdArchivados.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">   ARCHIVADOS</a></div>
<?php } ?>
				<div class="panel-tittle text-center"><a href="marcas.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">   MARCAS</a></div>

			</div>
			
<!-- --------------------------LISTADO-------------------------------------------------------- -->			

			<div class="mdl-tabs__panel is-active" id="tabListProducts">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC </div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>

<?php if (!in_array($_SESSION['Usuario_id_jer'], array(2,4,5,6))) { ?>
						<form action="productos.php" method="POST" enctype="multipart/form-data">

                            <div class="mdl-cell mdl-cell--6-col">
    <h5>Seleccionar Marca:</h5>
    <select class="mdl-textfield__input" id="marcaSelect" name="marca">
        <option value="">Seleccionar Marca</option>
        <?php
        foreach ($ListadoMarcas as $marca) {
            echo "<option value='{$marca}'>{$marca}</option>";
        }
        ?>
    </select>
                            </div>


                            <div class="mdl-cell mdl-cell--6-col">
    <h5>Productos:</h5>
    <select class="mdl-textfield__input" id="productoSelect" name="id_prod">
        <option value="">Seleccionar Producto </option>
    </select>
                            </div>

 <br>
    <button type="submit" name="accion2" value="modificar" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Modificar</button>
    <button type="submit" name="accion2" value="eliminar" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Eliminar</button>
    <button type="submit" name="accion2" value="archivar" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Archivar</button>
</form>
<?php } ?>
<script>
	//Productos segun la marca seleccionada, select dinamico
    document.getElementById('marcaSelect').addEventListener('change', function () {
        const marca = this.value;
        const productoSelect = document.getElementById('productoSelect');

        productoSelect.innerHTML = '<option value="">Seleccionar Producto para MODIFICAR</option>';

        if (marca) {
            fetch(`funciones/getProductosPorMarca.php?marca=${encodeURIComponent(marca)}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.id_prod;
                        option.textContent = `${producto.id_prod}, ${producto.producto}, Modelo: ${producto.MODELO}`;
                        productoSelect.appendChild(option);
                    });
                });
        }
    });
</script>

							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="searchProduct">
									<label class="mdl-textfield__label"></label>
								</div>
							</div>
						</form>
						
                        <div class="product-container">
    <?php 
    foreach ($ListadoProd as $producto) { 
        if ($producto['DISPO_P'] != 0) { ?>
            <div class="product-card mdl-card mdl-shadow--2dp">
                <h6 class="text-center tittles"><?php echo htmlspecialchars($producto['IDPROD']); ?></h6>
                <h4 class="text-center tittles"><?php echo htmlspecialchars($producto['PRODUCTO']); ?></h4>
                <div class="mdl-card__title">
                    <img src="<?php echo htmlspecialchars($producto['IMG']); ?>" alt="product" class="img-responsive">
                </div>
                <div class="mdl-card__supporting-text">
                    <small>Marca: <?php echo htmlspecialchars($producto['MARCA']); ?></small><br>
                    <small>Modelo: <?php echo htmlspecialchars($producto['MODELO']); ?></small><br>
                    <small>Producto: <?php echo htmlspecialchars($producto['TIPOPROD']); ?></small><br>
                    <small>Precio: <?php echo htmlspecialchars($producto['PRECIOV']); ?></small><br>
                    <small>Material: <?php echo htmlspecialchars($producto['MATERIAL']); ?></small><br>
                    <small>Dato: <?php echo htmlspecialchars($producto['DESC']); ?></small><br>
                </div>
            </div>
        <?php }
    } ?>
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