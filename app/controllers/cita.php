<?php
header('Content-Type: application/json');
	
$Users = new \core\BaseClass('usuarios') ;
$Data =  new \core\BaseClass('data') ;
$Cita =  new \core\BaseClass('cita') ;
$Serv =  new \core\BaseClass('servicios');
$Lbl =   new \models\Lbl();

include URL_AJAX . $_POST['controller'] . '/' . $_POST['action'] . '.php' ;

$id = empty($idData=$Data->getId())?$_POST['id']:$idData;
//int $idUser, string $action, int $idFK = 0, bool $status = true, string $tables = null 
$Logs->set($_SESSION['id_usuario'], $_POST['action'], $id, $r['success'], 'data');  

echo json_encode($r??false);