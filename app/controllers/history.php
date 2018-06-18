<?php
$days = $_POST['days']??DEFAULT_HISTORY_DAYS; 
$results =$Logs->get($days);

$accion = "null";

if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    $r['datos'] =  $results; 
    echo json_encode($r) ;
} else  {
    require_once URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ;
}
 