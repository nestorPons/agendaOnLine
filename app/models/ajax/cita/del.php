<?php

$DataDel = new \core\BaseClass('del_data');

$idCita = $_POST['id'];

$r['success'] = (!$DataDel->getRowById($idCita))?$Data->copyTableById('del_data', $idCita ):true;
if(isset($_POST['idCitaSer'])){
    
    //  Se eliminan los servicios de la cita por separado y si cita se vacia la elimino
    // Hace falta enviar post id de la tabla cita para eliminar por separado 
        
    $r['success'] = $Cita->copyTableBy('del_cita', $_POST['idCitaSer'] , 'id' ) ;    
    $r['success'] = $Cita->deleteBy('id' , $_POST['idCitaSer']);
    if($r['success'] && !$Cita->getRowBy('idCita', $idCita) ){
        $r['success'] = $Data->deleteById($idCita);
     }


} else {
    // Se elimina toda la cita
    
    $r['success'] = $Cita->copyTableBy('del_cita', $idCita , 'idCita' )
        ?($Data->deleteById($idCita)?$Cita->deleteBy('idCita' , $idCita):false)
        :false;
}