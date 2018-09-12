<?php
header('Content-Type: application/json');
	
$Users = new \core\BaseClass('usuarios') ;
$Data =  new \core\BaseClass('data') ;
$Cita =  new \core\BaseClass('cita') ;
$Serv =  new \core\BaseClass('servicios');
$Lbl =   new \models\Lbl();
$User = new \models\User($_SESSION['id_usuario']);

//Declaro variable action pq en el include satinizo el POST donde se elimina action y controller
$action = $_POST['action'];
include URL_AJAX . $_POST['controller'] . '/' . $action . '.php' ;

// crear historia
if ($action!='check' && $r['success']){  
    // Para que incluya la cl foranea en el log hay que declararla asi pq puede venir con distintos nombres
    $id = (isset($_POST['idCita'])) ? $_POST['idCita'] : ((isset($_POST['id'])) ? $_POST['id'] : $Data->getId()); 
    $Logs->set($_SESSION['id_usuario'], $action, $id, 'data');  
}

echo json_encode($r);