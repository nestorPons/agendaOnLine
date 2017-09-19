<?php
header('Content-Type: application/json');
	
$Users = new \core\BaseClass('usuarios') ;
$Data = new \core\BaseClass('data') ;
$Cita = new \core\BaseClass('cita') ;
$Serv =  new \core\BaseClass('servicios');

switch ($_POST['action']){
    case 'del' :
        $idCita = $_POST['id'];
        $conn = new core\Conexion();
        $r = $Data->copyTableById('del_data', $idCita ) ;
        if ($r)
            $r = $Cita->copyTableBy('del_cita', $idCita , 'idCita' ) ;
        if ($r)
            $r = $Data->deleteById($idCita);
        if ($r) 
            $r = $Cita->deleteBy('idCita' , $idCita);
        
        break;

    default:
        include URL_AJAX . $_POST['controller'] . '/' . $_POST['action'] . '.php' ;
        break;
}

echo json_encode($r??false);