<?php
header('Content-Type: application/json');
	
$Users = new \core\BaseClass('usuarios') ;
$Data =  new \core\BaseClass('data') ;
$Cita =  new \core\BaseClass('cita') ;
$Serv =  new \core\BaseClass('servicios');
$Lbl =   new \models\Lbl();

//Declaro variable action pq en el include satinizo el POST donde se elimina action y controller
$action = $_POST['action'];
include URL_AJAX . $_POST['controller'] . '/' . $action . '.php' ;

// crear historia
if ($action!='check'){ 
    $id = $Data->getId()??$_POST['idCita'];
    //int $idUser, string $action, int $idFK = 0, bool $status = true, string $tables = null 
    $Logs->set($_SESSION['id_usuario'], $action, $id, $r['success'], 'data');  
}

echo json_encode($r??false);