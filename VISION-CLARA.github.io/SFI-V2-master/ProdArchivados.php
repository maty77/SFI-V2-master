<?php  
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';


require_once 'funciones/selectMarca.php';
$ListadoMarca = ListarMarca($MiConexion);
$CantidadMarca= count($ListadoMarca);


require_once 'funciones/mostrarproducto.php';
$ListadoProd = ListarProd($MiConexion);
$CantidadProd= count($ListadoProd);


$query = "SELECT DISTINCT marca FROM marca";
$result = $conexion->query($query);

$ListadoMarcas = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ListadoMarcas[] = $row['marca'];
    }
}

require_once 'funciones/insertProd.php';

$mensajeC = '';
$mensajeE = '';

if (isset($_POST['accion3']) && isset($_POST['id_prod']) && !empty($_POST['id_prod'])) {
    $productoId = $_POST['id_prod'];
    $accion3 = $_POST['accion3'];

    if ($accion3 === 'alta') {

        $query = "UPDATE producto SET disponibilidad = '1' WHERE id_prod = ?";
        $stmt = mysqli_prepare($MiConexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $productoId);

        if (mysqli_stmt_execute($stmt)) {
            $mensajeC = "Producto desarchivado con éxito.";
        } else {
            $mensajeE = "Error al desarchivar el producto.";
        }
    } else {
        $mensajeE = "Acción no reconocida.";
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos Archivados</title>
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
           
            <div class="mdl-tabs__panel is-active" id="tabNewProduct">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="full-width panel mdl-shadow--2dp">
                            <div class="full-width panel-tittle bg-primary text-center tittles">
                                Productos archivados
                            </div>
                            <div class="full-width panel-content">
<section>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						
<?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC  -  <b><a href=productos.php>Volver</a></b></div>";
    }

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}
?>


						<form action="ProdArchivados.php" method="POST">
    <h5>Seleccionar Marca:</h5>
    <select class="mdl-textfield__input" id="marcaSelect" name="marca">
        <option>Seleccionar Marca</option>
        <?php
        foreach ($ListadoMarcas as $marca) {
            echo "<option value='{$marca}'>{$marca}</option>";
        }
        ?>
    </select>

    <h5>Activar Producto:</h5>
    <select class="mdl-textfield__input" id="productoSelect" name="id_prod">
        <option>Seleccionar Producto</option>
    </select>

 <br>
    <button type="submit" name="accion3" value="alta" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Alta</button>
</form>

<script>
    //Productos segun la marca seleccionada, select dinamico
    document.getElementById('marcaSelect').addEventListener('change', function () {
        const marca = this.value;
        const productoSelect = document.getElementById('productoSelect');

        productoSelect.innerHTML = '<option>Seleccionar Producto para MODIFICAR</option>';

        if (marca) {
            fetch(`funciones/ProdPorMarca.php?marca=${encodeURIComponent(marca)}`)
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
						<nav class="full-width menu-categories">
							<ul class="list-unstyle text-center">
								<li><a href="#!">Category 1</a></li>
								<li><a href="#!">Category 2</a></li>
								<li><a href="#!">Category 3</a></li>
								<li><a href="#!">Category 4</a></li>
							</ul>
						</nav>
						
						<div class="product-container">
    <?php 
    for ($i = 0; $i < $CantidadProd; $i++) { 
        if ($ListadoProd[$i]['DISPO_P'] != 1) { ?>
            <div class="product-card mdl-card mdl-shadow--2dp">
                 <h6 class="text-center tittles"><?php echo $ListadoProd[$i]['IDPROD']; ?></h6>
                <h4 class="text-center tittles"><?php echo $ListadoProd[$i]['PRODUCTO']; ?></h4>
                <div class="mdl-card__title">
                    <img src="<?php echo $ListadoProd[$i]['IMG']; ?>"  alt="product" class="img-responsive">
                </div>
                <div class="mdl-card__supporting-text">
                    <small>Marca: <?php echo $ListadoProd[$i]['MARCA']; ?></small><br>
                     <small>Modelo: <?php echo $ListadoProd[$i]['MODELO']; ?></small><br>
                    <small>Producto: <?php echo $ListadoProd[$i]['TIPOPROD']; ?></small><br>
                     <small>Precio: <?php echo $ListadoProd[$i]['PRECIOV']; ?></small><br>
                      <small>Material <?php echo $ListadoProd[$i]['MATERIAL']; ?></small><br>
                </div>
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="zmdi zmdi-more"></i>
                </button>
                <div class="mdl-card__actions mdl-card--border"></div>
            </div>
        <?php } 
    } ?>
</div>
							
								</div>
							</div>
						</div>
					</div>
				

		</div>

	</section>
</body>
</html>