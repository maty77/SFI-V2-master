<?php
session_start();
require_once 'clientesController.php';
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
    <script src="js/material.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/main.js"></script>
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
    .color {
        background-color: #b6bdf8;
    }
</style>
<body>

<?php require_once 'inc/barralateral.inc.php'; ?>

<section class="full-width pageContent">
    <?php require_once 'inc/barranav.inc.php'; ?>

    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-accounts-list"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">CLIENTES</p>
        </div>
    </section>

    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__tab-bar">
            <a href="#tabListClient" class="mdl-tabs__tab is-active">EXISTENTES</a>
            <div class="panel-tittle text-center">
                <a href="registrarcliente.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">REGISTRAR CLIENTE</a>
            </div>
        </div>

        <div class="mdl-tabs__panel is-active" id="tabListClient">
            <div class="mdl-grid">
                <div class="full-width panel-tittle bg-success text-center tittles">Clientes Activos</div>
                <div class="full-width panel-content">

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
                            <?php foreach ($ListadoCli as $cliente): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cliente['NOM_CLI']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['APE_CLI']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['DNI_CLI']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['MAIL_CLI']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['CIU_CLI']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['PROVINCIA']); ?></td>
                                    <td><?php echo htmlspecialchars($cliente['CON_CLI']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <br><br>
                    <button onclick="window.open('Reportes/reporteClientes.php', '_blank')" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Generar reporte de clientes</button>
                    <br><br><br>

                    <?php require_once 'funciones/bajaCLI.php'; ?>
                    <?php require_once 'funciones/altaCLI.php'; ?>

                    <!-- Aquí podés insertar los formularios de baja, alta y modificar como ya los tenías. No es necesario eliminarlos todavía, aunque en el futuro te conviene moverlos a un archivo separado. -->

                </div>
            </div>
        </div>
    </div>
</section>

<script>
function sortTable(n, thElement) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("miTabla");

    var headers = table.getElementsByTagName("th");
    for (var j = 0; j < headers.length; j++) {
        headers[j].classList.remove("active-header");
    }
    thElement.classList.add("active-header");

    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("tbody")[0].rows;
        for (i = 0; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[n];
            y = rows[i + 1].getElementsByTagName("td")[n];

            if (n === 2 || n === 6) {
                var numX = parseFloat(x.innerHTML) || 0;
                var numY = parseFloat(y.innerHTML) || 0;
                if ((dir === "asc" && numX > numY) || (dir === "desc" && numX < numY)) {
                    shouldSwitch = true;
                    break;
                }
            } else if ((dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) || (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else if (switchcount === 0 && dir === "asc") {
            dir = "desc";
            switching = true;
        }
    }
}
</script>

</body>
</html>
