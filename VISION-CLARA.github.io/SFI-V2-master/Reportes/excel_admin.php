<?php
require_once '../funciones/conexion.php';
$MiConexion = ConexionBD();
require_once '../funciones/autenticacion.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_admin.xls");
header("Pragma: no-cache");
header("Expires: 0");

$SQL = "SELECT  u.nombre AS nombre, 
                u.apellido AS apellido, 
                u.DNI_U AS dni, 
                u.usuario AS usuario, 
                u.contacto AS contacto, 
                j.jerarquia as jerarquia, 
                u.contrasena as contrasena
        FROM usuario u, jerarquia j
        WHERE  u.id_jer=j.id_jer AND u.id_jer != 2 AND u.Disponibilidad = 1
        ORDER BY j.jerarquia ASC";

$result = $MiConexion->query($SQL);

echo "<table border='1'>";
echo "<thead>
        <tr>
             <th>Jerarquia</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Usuario</th>
            <th>Contacto</th>
            <th>Contraseña</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['jerarquia']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['apellido']}</td>
            <td>{$row['dni']}</td>
            <td>{$row['usuario']}</td>
            <td>{$row['contacto']}</td>
            <td>{$row['contrasena']}</td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
?>
