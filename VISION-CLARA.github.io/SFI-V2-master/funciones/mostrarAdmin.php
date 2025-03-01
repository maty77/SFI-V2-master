<?php
function ListarAdmin($vConexion) {

    $Listado=array();

    $SQL = "SELECT u.nombre, u.apellido, u.DNI_U, u.usuario, u.contacto, u.Disponibilidad, j.jerarquia, u.Contrasena
    FROM usuario u, jerarquia j
    WHERE u.id_jer=j.id_jer AND u.id_jer != 2
    ORDER BY u.apellido ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['NOM_U'] = $data['nombre'];
            $Listado[$i]['APE_U'] = $data['apellido'];
            $Listado[$i]['DNIuser'] = $data['DNI_U'];
            $Listado[$i]['USER'] = $data['usuario'];
            $Listado[$i]['CON_U'] = $data['contacto'];
            $Listado[$i]['DISPO_U'] = $data['Disponibilidad'];
            $Listado[$i]['JERARQUIA'] = $data['jerarquia'];
            $Listado[$i]['CONTRA'] = $data['Contrasena'];

            $i++;
    }


    return $Listado;

}




?>