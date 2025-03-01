<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_proveedores.xls");
header("Pragma: no-cache");
header("Expires: 0");

$SQL = "SELECT prov.proveedor as nombre, 
               prov.id_proveedor as cuit,
               prov.email as email,
               prov.ciudad as ciudad,
               prov.domicilio as domicilio,
               p.Provincia_desc as provincia,
               prov.contacto as contacto
        FROM Proveedor prov
        INNER JOIN provincia p ON p.id_prov = prov.id_prov
        WHERE prov.Disponibilidad = 1";

$result = $MiConexion->query($SQL);

echo "<table border='1'>";
echo "<thead>
        <tr>
            <th>Proveedor</th>
            <th>CUIT</th>
            <th>Email</th>
            <th>Ciudad</th>
            <th>Domicilio</th>
            <th>Provincia</th>
            <th>Contacto</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['nombre']}</td>
            <td>{$row['cuit']}</td>
            <td>{$row['email']}</td>
            <td>{$row['ciudad']}</td>
            <td>{$row['domicilio']}</td>
            <td>{$row['provincia']}</td>
            <td>{$row['contacto']}</td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
?>
