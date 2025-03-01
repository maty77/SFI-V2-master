<?php
function ListarMarca($vConexion) {

    $Listado=array();

    $SQL = "SELECT m.Id_Marca, m.Marca, e.estatus, m.Disponibilidad FROM Marca m, Estatus e WHERE e.id_estatus=m.id_estatus";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDMARCA'] = $data['Id_Marca'];
            $Listado[$i]['MARCADESC'] = $data['Marca'];
            $Listado[$i]['ESTATUS'] = $data['estatus'];
            $Listado[$i]['DISPO'] = $data['Disponibilidad'];
            $i++;
    }


    return $Listado;

}
?>