<?php
$days = $_POST['days']??DEFAULT_HISTORY_DAYS; 

$results =$Logs->get($_POST['fecha']);

$accion = "null";

if (isset($_POST['action'])) {
    header('Content-Type: application/json');
        $r['datos'] =  $results; 
    echo json_encode($r) ;
} else  {
    \core\Tools::minifierJS($_POST['controller']); 
    require_once URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ;
}
 