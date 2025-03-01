<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_promociones.xls");
header("Pragma: no-cache");
header("Expires: 0");

$SQL = "SELECT p.id_promo as codigo, 
               p.promo as nombre,
               p.terminos as terminos,
               p.valor_descuento as descuento
        FROM promociones p
        WHERE p.activo = 1";

$result = $MiConexion->query($SQL);

echo "<table border='1'>";
echo "<thead>
        <tr>
            <th>Codigo</th>
            <th>Promocion</th>
            <th>Terminos</th>
            <th>Descuento</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['codigo']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['terminos']}</td>
            <td>%{$row['descuento']}</td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
?>
