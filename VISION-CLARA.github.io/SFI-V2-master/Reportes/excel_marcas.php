<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();

require_once '../funciones/autenticacion.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_marcas.xls");
header("Pragma: no-cache");
header("Expires: 0");

$SQL = "SELECT m.id_marca as codigo, 
               m.marca as marca,
              e.estatus as estatus
        FROM marca m, estatus e
        WHERE m.id_estatus=e.id_estatus AND m.disponibilidad = 1
        ORDER BY m.marca ASC";

$result = $MiConexion->query($SQL);

echo "<table border='1'>";
echo "<thead>
        <tr>
            <th>Codigo</th>
            <th>Marca</th>
            <th>Estatus</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['codigo']}</td>
            <td>{$row['marca']}</td>
            <td>{$row['estatus']}</td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
?>
