<?php 
if (strlen(session_id()) < 1) session_start ();

require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/config.controller.php');
require_once  $_SERVER['DOCUMENT_ROOT']. '/php/libs/tools.php' ;

include $_SERVER['DOCUMENT_ROOT'].'/php/admin/main/lbl.class.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/admin/main/view.function.php';

if (isset ($_POST['action'])){
    switch ($_POST['action']) {
        case 'del' :
            $lbl = new main\Lbl($_POST) ;
            $lbl->edit($_POST) ;
            break ;

        case 'view' :
            $fecha_inicio = $_GET['fecha'] ;
            $datos_agenda = datosAgenda($fecha_inicio);
            $ids_existentes = json_decode(stripslashes($_GET['ids']));
            main\view($datos_agenda,$fecha_inicio,$ids_existentes);
            break ;

        case 'del' :
            $lbl = new main\Lbl($_GET) ;
            $lbl->del() ;
            break ;
    }
}