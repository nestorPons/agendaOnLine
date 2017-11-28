<?php
header('Content-Type: application/json');

require_once URL_FUNCTIONS  . 'tools.php';
	
$Users = new \core\BaseClass('usuarios') ;
$Data =  new \core\BaseClass('data') ;
$Cita =  new \core\BaseClass('cita') ;
$Serv =  new \core\BaseClass('servicios');
$Lbl =   new \models\Lbl();

include URL_AJAX . $_POST['controller'] . '/' . $_POST['action'] . '.php' ;

echo json_encode($r??false);