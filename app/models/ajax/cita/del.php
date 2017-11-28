<?php

$DataDel = new \core\BaseClass('del_data');

$idCita = $_POST['id'];

$r = (!$DataDel->getRowById($idCita))?$Data->copyTableById('del_data', $idCita ):true;
if(isset($_POST['idCitaSer'])){
    
    //  Se eliminan los servicios de la cita por separado y si cita se vacia la elimino
    // Hace falta enviar post id de la tabla cita para eliminar por separado 
        
    $r = $Cita->copyTableBy('del_cita', $_POST['idCitaSer'] , 'id' ) ;    
    $r = $Cita->deleteBy('id' , $_POST['idCitaSer']);
    if($r && !$Cita->getRowBy('idCita', $idCita) ){
        $r = $Data->deleteById($idCita);
     }


} else {
    // Se elimina toda la cita
    
    $r = ($r)?$Cita->copyTableBy('del_cita', $idCita , 'idCita' ):false ;
    $r = ($r)?$Data->deleteById($idCita):false;
    $r = ($r)?$Cita->deleteBy('idCita' , $idCita):false;
    
}