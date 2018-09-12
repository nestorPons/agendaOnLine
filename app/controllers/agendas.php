<?php
if (isset($_POST['action'])) {

    header('Content-Type: application/json');
    
    $r =  include URL_AJAX . $controller . '/' . $_POST['action'] .  '.php';
     
    $Logs->set( $_SESSION['id_usuario'], $_POST['action'], (int)$_POST['id'], $_POST['controller']);
    echo json_encode($r);

} else { 

    include URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 
}