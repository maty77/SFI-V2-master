<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_clientes.xls");
header("Pragma: no-cache");
header("Expires: 0");

$SQL = "SELECT c.nombre as nombre, 
               c.apellido as apellido,
               c.DNI_CLI as dni,
               c.email as email,
               c.ciudad as ciudad,
               p.Provincia_desc as provincia,
               c.contacto as contacto
        FROM cliente c
        INNER JOIN provincia p ON p.id_prov = c.id_prov
        WHERE c.Disponibilidad = 1";

$result = $MiConexion->query($SQL);

echo "<table border='1'>";
echo "<thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Email</th>
            <th>Ciudad</th>
            <th>Provincia</th>
            <th>Contacto</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['nombre']}</td>
            <td>{$row['apellido']}</td>
            <td>{$row['dni']}</td>
            <td>{$row['email']}</td>
            <td>{$row['ciudad']}</td>
            <td>{$row['provincia']}</td>
            <td>{$row['contacto']}</td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
?>
