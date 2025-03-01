<?php
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
require_once 'funciones/autenticacion.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');


require_once 'funciones/idautomaticoVENTA.php';
require_once 'funciones/registrarVENTA.php';
require_once 'funciones/selectMonturas.php';

$fechaHoraActual = date('Y/m/d H:i:s');


require_once 'funciones/selectPromo.php';
$ListadoPromo = ListarPromo($MiConexion);
$CantidadPromo= count($ListadoPromo);

require_once 'funciones/selectFPago.php';
$ListadoFP = ListarFPago($MiConexion);
$CantidadFP= count($ListadoFP);

require_once 'funciones/selectCob.php';
$ListadoCOB = ListarCobertura($MiConexion);
$CantidadCOB= count($ListadoCOB);

require_once 'funciones/selectEN.php';
$ListadoEN = ListarEntrega($MiConexion);
$CantidadEN= count($ListadoEN);

require_once 'funciones/selectCristal.php';
$ListadoCristal = ListarCristal($MiConexion);
$CantidadCristal= count($ListadoCristal);

require_once 'funciones/listarTrat.php';
$ListadoTrat = ListarTrat($MiConexion);
$CantidadTrat= count($ListadoTrat);

$mensaje='';
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SISTEMA DE VENTA</title>
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

	<style>
    .error-mensaje {
        color: white;
        font-size: 14px;
        margin-top: 5px;
        display: block;
        height: 45px;
        background-color: red;
        line-height: 45px;
        font-size: 15px;
        text-align: center;
    }

    .input-error {
        border: 2px solid red !important;
        background-color: #ffe6e6;
    }
</style>

</head>
<body>
	<!-- Notifications area -->

	<!-- navLateral -->
<?php require_once 'inc/barralateral.inc.php';  ?>

	<!-- pageContent -->
	<section class="full-width pageContent">
		<!-- navBar -->
		<?php require_once 'inc/barranav.inc.php'; ?>
		
	
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewProduct" class="mdl-tabs__tab is-active"><i class="zmdi zmdi-shopping-cart"></i></a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewProduct">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
            <?php
// Mostrar los mensajes solo si no están vacíos
if (!empty($mensajeC)) {
    echo "<div class='mensaje-correcto'>$mensajeC   -  <b><a href=sistemaventas.php>Registrar otro venta</a></b></div>";
}

if (!empty($mensajeE)) {
    echo "<div class='mensaje-alerta'>$mensajeE</div>";
}

?>

						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								NUEVA VENTA
							</div>
							<div class="full-width panel-content">								

<form method="POST" enctype="multipart/form-data">
  <div class="mdl-grid">

    <!-- Registro de Venta -->
    <div class="mdl-cell mdl-cell--12-col">
      <legend class="text-condensedLight">
        <i class="zmdi zmdi-border-color"></i> &nbsp; REGISTRO
      </legend>
      <br>
    </div>

    <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet">
      <h5>
        <strong class="text-condensedLight">
          <i class="zmdi zmdi-tag"></i> Número de Venta:
        </strong>
      </h5>
      <label class="text-condensedLight" id="id_venta">
        <strong><?php echo htmlspecialchars($nuevoID); ?></strong>
      </label>
      <input type="hidden" name="id_venta" value="<?php echo htmlspecialchars($nuevoID); ?>">
    </div>

    <div class="mdl-cell mdl-cell--6-col">
      <h5>
        <strong class="text-condensedLight">
          <i class="zmdi zmdi-account-circle"></i> &nbsp; VENDEDOR: <br>
          <?php echo $_SESSION['Usuario_Nombre'].' '. $_SESSION['Usuario_Apellido'] ?>
        </strong>
      </h5>
      <br>
      <input type="hidden" name="DNI_U" value="<?php echo $_SESSION['Usuario_DNI_U'] ?>">
    </div>

    <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="number" pattern="-?[0-9- ]*(\.[0-9]+)?" id="DNI" name="DNI" value="<?php echo !empty($_POST['DNI']) ? $_POST['DNI'] : ''; ?>">
        <label class="mdl-textfield__label" for="BarCode">DNI CLIENTE</label>
        <span class="mdl-textfield__error">Invalid DNI</span>
      </div>
      <?php if (!empty($mensaje_error)) { ?>
        <p id="errorMensaje" class="error-mensaje"><?php echo $mensaje_error; ?></p>
      <?php } ?>
    </div>

    <div class="mdl-cell mdl-cell--6-col">
      <div class="mdl-textfield mdl-js-textfield">
        <select class="mdl-textfield__input" aria-label="Selector" id="selectorCOB" name="id_cob">
          <option>SELECCIONAR COBERTURA MEDICA</option>
          <?php 
            for ($i=0; $i < $CantidadCOB; $i++) {
              $selected = (!empty($_POST['id_cob']) && $_POST['id_cob'] ==  $ListadoCOB[$i]['IDCOB']) ? 'selected' : '';
          ?>
            <option value="<?php echo $ListadoCOB[$i]['IDCOB']; ?>" <?php echo $selected; ?>>
              <?php echo $ListadoCOB[$i]['COB']; ?>
            </option>
          <?php } ?>
        </select>     
      </div>
    </div>

    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
      <br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="number" pattern="-?[0-9- ]*(\.[0-9]+)?" id="id_Prod" name="id_Prod" value="<?php echo !empty($_POST['id_Prod']) ? $_POST['id_Prod'] : ''; ?>">
        <label class="mdl-textfield__label">CODIGO DE PRODUCTO</label>
      </div>
    </div>

    <div class="mdl-cell mdl-cell--4-col">
      <div class="mdl-textfield mdl-js-textfield">
        <label class="mdl-textfield__label" for="StrockProduct">CANTIDAD</label>
        <br><br>
        <input type="number" name="cantprod">
      </div>
    </div>

    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <button type="button" id="agregarProducto">AGREGAR</button>
        <label class="mdl-textfield__label" for="BarCode"></label>
        <span class="mdl-textfield__error"></span>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        let dniInput = document.getElementById('DNI');
        let errorMensaje = document.getElementById('errorMensaje');
        if (errorMensaje) {
          dniInput.classList.add('input-error');
        }
        dniInput.addEventListener('input', function () {
          dniInput.classList.remove('input-error');
          if (errorMensaje) {
            errorMensaje.style.display = 'none';
          }
        });
      });
    </script>

    <!-- TABLA DE PRODUCTOS -->
    <div class="full-width divider-menu-h"></div>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
        <div class="table-responsive">
          <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
            <thead>
              <tr>
                <th>CODIGO</th>
                <th>PRODUCTO</th>
                <th>MARCA</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>   
                <th>TOTAL</th>                          
                <th>ACCION</th>
              </tr>
            </thead>
            <tbody>
              <!-- Las filas nuevas se agregarán aquí -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <input type="hidden" name="detallesVenta" id="detallesVentaInput">

    <!-- Bloque para Registro Oftalmológico -->
    <div class="mdl-cell mdl-cell--12-col">
      <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="activarRegistroOf">
        <input type="checkbox" id="activarRegistroOf" class="mdl-switch__input">
        <span class="mdl-switch__label">¿Registrar Datos Oftalmológicos?</span>
      </label>
    </div>

    <!-- Campos para registros oftalmológicos (se agregan de forma dinámica) -->
    <input type="hidden" name="num_recetas" id="num_recetas" value="0">
    <div id="RegistrosOftal" class="mdl-cell mdl-cell--12-col">
      <button type="button" id="añadirRegistroOftal">Añadir Registro Oftalmológico</button>
    </div>

    <!-- Mas de venta -->
    <div class="mdl-cell mdl-cell--8-col">
      <div class="mdl-textfield mdl-js-textfield">
        <select class="mdl-textfield__input" aria-label="Selector" id="promoSelector" name="id_promo">
          <option>SELECCIONAR PROMO</option>
          <?php 
            for ($i=0; $i < $CantidadPromo; $i++) {
              $selected = (!empty($_POST['id_promo']) && $_POST['id_promo'] == $ListadoPromo[$i]['IDPROMO']) ? 'selected' : '';
          ?>
            <option value="<?php echo $ListadoPromo[$i]['IDPROMO']; ?>" data-descuento="<?php echo $ListadoPromo[$i]['VALOR']; ?>" <?php echo $selected; ?>>
              <?php echo $ListadoPromo[$i]['PROMO'] . ' , Descuento: ' . $ListadoPromo[$i]['VALOR'] . '%'; ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </div>

    <!-- Total de la Compra -->
    <div class="mdl-cell mdl-cell--12-col">
      <h5>
        <strong>Total de la Compra:</strong> $<span id="total">0.00</span> <i class="zmdi zmdi-local-mall"></i>
      </h5>
    </div>
    <br>
    <input type="hidden" name="total_input" id="total_input">

    <div class="mdl-cell mdl-cell--6-col">
      <div class="mdl-textfield mdl-js-textfield">
        <select class="mdl-textfield__input" aria-label="Selector" id="selectorPAGO" name="id_pago">
          <option>SELECCIONAR FORMA DE PAGO</option>
          <?php 
            for ($i=0; $i < $CantidadFP; $i++) {
              $selected = (!empty($_POST['id_pago']) && $_POST['id_pago'] ==  $ListadoFP[$i]['IDFP']) ? 'selected' : '';
          ?>
            <option value="<?php echo $ListadoFP[$i]['IDFP']; ?>" <?php echo $selected; ?>>
              <?php echo $ListadoFP[$i]['PAGO']; ?>
            </option>
          <?php } ?>
        </select>     
      </div>
    </div>

    <div class="mdl-cell mdl-cell--6-col">
      <div class="mdl-textfield mdl-js-textfield">
        <select class="mdl-textfield__input" aria-label="Selector" id="selectorEN" name="id_entrega">
          <option>SELECCIONAR TIPO DE ENTREGA</option>
          <?php 
            for ($i=0; $i < $CantidadEN; $i++) {
              $selected = (!empty($_POST['id_entrega']) && $_POST['id_entrega'] ==  $ListadoEN[$i]['IDEN']) ? 'selected' : '';
          ?>
            <option value="<?php echo $ListadoEN[$i]['IDEN']; ?>" <?php echo $selected; ?>>
              <?php echo $ListadoEN[$i]['ENTREGA']; ?>
            </option>
          <?php } ?>
        </select>     
      </div>
    </div>

    <br><br><br>

    <?php $fechaHoraActual = date('Y/m/d H:i:s'); ?>
    <input type="hidden" name="fecha_hora_venta" value="<?php echo $fechaHoraActual; ?>">

    <div class="mdl-cell mdl-cell--12-col">
      <h5 class="text-condensedLight text-center">
        <i class="zmdi zmdi-border-color"></i> &nbsp; <strong>REGISTRAR LA VENTA</strong>
      </h5>
      <br>
      <p class="text-center">

        <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-success text-center" id="btnRegistrar" type="submit">
          <i class="zmdi zmdi-plus"></i>
        </button>

        <div class="mdl-tooltip" for="btnRegistrar">REGISTRAR VENTA</div>
      </p>
    </div>
  </div>
</form>



<script>
document.addEventListener('DOMContentLoaded', function () {
  /* === LÓGICA DE VENTAS === */
  const promoSelector = document.getElementById('promoSelector');
  const totalVentaElement = document.getElementById('total');
  const totalInputElement = document.getElementById('total_input');
  const detallesVentaInput = document.getElementById('detallesVentaInput');
  let totalVenta = 0;
  let detallesVenta = [];
  
  let costosAdicionales = {
    cristales: {},
    tratamientos: {}
  };

  function actualizarTotales() {
    const selectedPromo = promoSelector.selectedOptions[0];
    const descuento = selectedPromo ? parseFloat(selectedPromo.getAttribute('data-descuento')) || 0 : 0;
    
    let totalGeneral = totalVenta;
    
    // Sumar todos los cristales
    for (const id in costosAdicionales.cristales) {
      totalGeneral += costosAdicionales.cristales[id];
    }
    
    // Sumar todos los tratamientos
    for (const id in costosAdicionales.tratamientos) {
      totalGeneral += costosAdicionales.tratamientos[id];
    }
    
    // Aplicar descuento si existe
    const nuevoTotal = totalGeneral - (totalGeneral * (descuento / 100));
    
    totalVentaElement.textContent = nuevoTotal.toFixed(2);
    totalInputElement.value = nuevoTotal.toFixed(2);
  }
  
  promoSelector.addEventListener("change", actualizarTotales);

  const agregarBtn = document.querySelector('button#agregarProducto');
  const tablaProductos = document.querySelector('table tbody');
  if (agregarBtn) {
    agregarBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const idProducto = document.getElementById('id_Prod').value;
      const cantidad = parseInt(document.querySelector('input[name="cantprod"]').value);
      if (idProducto && cantidad > 0) {
        fetch('funciones/getProducto.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `codigoProducto=${idProducto}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
            return;
          }
          const subtotal = data.precio_venta * cantidad;
          totalVenta += subtotal;
          const nuevaFila = document.createElement('tr');
          nuevaFila.innerHTML = `
            <td>${data.id_prod}</td>
            <td>${data.producto}</td>
            <td>${data.marca}</td>
            <td>${data.precio_venta}</td>
            <td>${cantidad}</td>
            <td>${subtotal.toFixed(2)}</td>
            <td><button class="eliminar-btn">Eliminar</button></td>
          `;
          tablaProductos.appendChild(nuevaFila);
          actualizarTotales();
          detallesVenta.push({
            id_prod: parseInt(data.id_prod),
            id_tipoprod: data.id_tipoprod,
            producto: data.producto,
            cantprod: cantidad,
            subtotal: subtotal
          });
          detallesVentaInput.value = JSON.stringify(detallesVenta);
          nuevaFila.querySelector('.eliminar-btn').addEventListener('click', function () {
            totalVenta -= subtotal;
            detallesVenta = detallesVenta.filter(item => item.id_prod !== parseInt(data.id_prod));
            nuevaFila.remove();
            actualizarTotales();
            detallesVentaInput.value = JSON.stringify(detallesVenta);
            // Actualizamos el select de monturas si existe
            actualizarSelectMonturas();
          });
          // Actualizamos el select de monturas cada vez que se agrega un producto
          actualizarSelectMonturas();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Hubo un problema al obtener el producto.');
        });
      } else {
        alert('Por favor, completa todos los campos correctamente.');
      }
    });
  }

  /* === FUNCIÓN PARA ACTUALIZAR LOS SELECTS DE MONTURAS === */
  function actualizarSelectMonturas() {
    const selects = document.querySelectorAll('.selectMonturas');
    selects.forEach(select => {
      // Guardamos el valor actual para restaurarlo luego
      const valorActual = select.value;
      // Reiniciamos el select
      select.innerHTML = '<option value="">Seleccionar Montura:</option>';
      // Filtramos solo los productos monturas (id_tipoprod == 2) del array de detallesVenta
      const monturas = detallesVenta.filter(item => item.id_tipoprod == 2);
      // Usamos un Set para evitar duplicados
      const productosAgregados = new Set();
      monturas.forEach(item => {
        if (!productosAgregados.has(item.id_prod)) {
          productosAgregados.add(item.id_prod);
          const option = document.createElement('option');
          option.value = item.id_prod;
          option.textContent = item.producto;
          select.appendChild(option);
        }
      });
      // Restauramos el valor seleccionado si aún existe
      select.value = valorActual;
    });
  }

  /* === BLOQUE DE REGISTRO OFTALMOLÓGICO === */
  const activarRegistroOf = document.getElementById("activarRegistroOf");
  const registrosOftal = document.getElementById("RegistrosOftal");
  let contadorRecetas = 0;  // Para IDs únicos

  function toggleRegistrosOftal() {
    if (activarRegistroOf.checked) {
      registrosOftal.style.display = "block";
      actualizarSelectMonturas(); // Actualizamos los selects al mostrar el bloque
    } else {
      registrosOftal.style.display = "none";
      
      // Al desactivar, eliminamos todos los costos adicionales
      costosAdicionales.cristales = {};
      costosAdicionales.tratamientos = {};
      actualizarTotales();
    }
  }
  activarRegistroOf.addEventListener("change", toggleRegistrosOftal);
  registrosOftal.style.display = "none";

  function añadirNuevoRegistro() {
    contadorRecetas++;
    const idReceta = `${contadorRecetas}`;
    const nuevoContenedor = document.createElement('div');
    nuevoContenedor.classList.add('mdl-cell', 'mdl-cell--12-col');
    nuevoContenedor.innerHTML = `
      <h5><strong>REGISTRO OFTALMOLÓGICO N° ${idReceta}</strong></h5>
      <div class="mdl-textfield mdl-js-textfield">
          <b>Montura: </b>
          <select class="mdl-textfield__input selectMonturas" aria-label="Selector" id="selectMonturas_${idReceta}" name="id_montura[]">
              <option value="">Seleccionar Montura:</option>
          </select>
      </div>
      <div class="mdl-textfield mdl-js-textfield">
          <b>Cristal: </b>
          <select class="mdl-textfield__input selectCristal" aria-label="Selector" id="cristalSelector_${idReceta}" name="id_cristal[]" data-receta="${idReceta}">
              <option value="">Seleccionar Cristal:</option>
              <?php 
              for ($i=0; $i < $CantidadCristal; $i++) {
                $selected = (!empty($_POST['id_cristal']) && $_POST['id_cristal'] ==  $ListadoCristal[$i]['IDCRIS']) ? 'selected' : '';
              ?>
                <option value="<?php echo $ListadoCristal[$i]['IDCRIS']; ?>" data-precio="<?php echo $ListadoCristal[$i]['PRECIOCRIS']; ?>" <?php echo $selected; ?>>
                  <?php echo $ListadoCristal[$i]['TIPOCRIS']. ', $' . $ListadoCristal[$i]['PRECIOCRIS'] . ''; ?>
                </option>
              <?php } ?>
          </select>
      </div>
      <div>
          <b>Índice de Refracción:</b>
          <input class="mdl-textfield__input" type="number" id="IND_REF_${idReceta}" step="any" name="IND_REF[]">
      </div>
              <br>
      <div>
          <b>Tratamiento/s:</b><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="1" data-precio="<?php echo $ListadoTrat[0]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="1"> Antireflejante + $<?php echo $ListadoTrat[0]['PRECIOTRAT']; ?><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="2" data-precio="<?php echo $ListadoTrat[1]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="2"> Endurecido + $<?php echo $ListadoTrat[1]['PRECIOTRAT']; ?><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="3" data-precio="<?php echo $ListadoTrat[2]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="3"> Antivaho + $<?php echo $ListadoTrat[2]['PRECIOTRAT']; ?><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="4" data-precio="<?php echo $ListadoTrat[3]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="4"> Fotocromático + $<?php echo $ListadoTrat[3]['PRECIOTRAT']; ?><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="5" data-precio="<?php echo $ListadoTrat[4]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="5"> Polarizado + $<?php echo $ListadoTrat[4]['PRECIOTRAT']; ?><br>
          <input type="checkbox" class="tratamiento-check" name="tratamientos[${contadorRecetas}][]" value="6" data-precio="<?php echo $ListadoTrat[5]['PRECIOTRAT']; ?>" data-receta="${idReceta}" data-tratamiento="6"> Luz Azul + $<?php echo $ListadoTrat[5]['PRECIOTRAT']; ?>
      </div>
          <br>

      <div>
          <b>Ojo Derecho:</b>
          <fieldset>
              <input type="radio" name="Der[${contadorRecetas}]" value="Esferico"> Esférico<br>
              <input type="radio" name="Der[${contadorRecetas}]" value="Cilindro"> Cilindro<br>
          </fieldset>
      </div>
          <br>
      <div>
          <b>Ojo Izquierdo:</b>
          <fieldset>
              <input type="radio" name="Izq[${contadorRecetas}]" value="Esferico"> Esférico<br>
              <input type="radio" name="Izq[${contadorRecetas}]" value="Cilindro"> Cilindro<br>
          </fieldset>
      </div>
          <br>
      <div>
          <b>Adjuntar Receta:</b>
          <input type="file" name="receta[]">
      </div>
      <br><br>
    `;
    registrosOftal.appendChild(nuevoContenedor);
    document.getElementById("num_recetas").value = contadorRecetas;
    actualizarSelectMonturas();
    
    const cristalSelector = nuevoContenedor.querySelector('.selectCristal');
    cristalSelector.addEventListener('change', function() {
      const recetaId = this.getAttribute('data-receta');
      const selectedOption = this.options[this.selectedIndex];
      const precio = selectedOption.getAttribute('data-precio') ? parseFloat(selectedOption.getAttribute('data-precio')) : 0;
      
      // Actualizar el objeto de costos adicionales
      if (precio > 0) {
        costosAdicionales.cristales[`receta_${recetaId}`] = precio;
      } else {
        delete costosAdicionales.cristales[`receta_${recetaId}`];
      }
      
      actualizarTotales();
    });
    
    const tratamientoChecks = nuevoContenedor.querySelectorAll('.tratamiento-check');
    tratamientoChecks.forEach(check => {
      check.addEventListener('change', function() {
        const recetaId = this.getAttribute('data-receta');
        const tratamientoId = this.getAttribute('data-tratamiento');
        const precio = parseFloat(this.getAttribute('data-precio')) || 0;
        const keyId = `receta_${recetaId}_trat_${tratamientoId}`;
        
        if (this.checked) {
          costosAdicionales.tratamientos[keyId] = precio;
        } else {
          delete costosAdicionales.tratamientos[keyId];
        }
        
        actualizarTotales();
      });
    });
  }
  document.getElementById("añadirRegistroOftal").addEventListener("click", añadirNuevoRegistro);
});
</script>