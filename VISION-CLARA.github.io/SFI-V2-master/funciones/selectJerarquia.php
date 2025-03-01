<?php
function ListarJerarquia($vConexion) {

    $Listado=array();

    $SQL = "SELECT Id_Jer, Jerarquia FROM Jerarquia WHERE Id_Jer!= 2";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDJER'] = $data['Id_Jer'];
            $Listado[$i]['JERARQUIA'] = $data['Jerarquia'];
            $i++;
    }


    return $Listado;

}
?>