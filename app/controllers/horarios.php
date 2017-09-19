<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/controllers/conn.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/myclass/Horarios.php');

$horarios = new models\Horarios();

if ($_GET) {
    header('Content-Type: application/json');
    switch ($_GET['action']) {
        case 'save' :
            echo json_encode($horarios->save_horarios($_GET['data']));
            break;
        case 'del' :
            echo json_encode($horarios->del_horarios($_GET['id']));
            break;
    }
}