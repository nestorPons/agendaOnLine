<?php 
if (strlen(session_id()) < 1) session_start ();

require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/config.controller.php');
require_once  $_SERVER['DOCUMENT_ROOT']. '/php/libs/tools.php' ;

spl_autoload_register(
    function ( $nameClass ) {
        $explodes = explode('\\' , $nameClass) ; 
        $nameSpace = $explodes[0] ;
        $nameClass =  $explodes[1] ;
        $nameFile = strtolower($nameClass);
print_r ($explodes) ;
        include_once "$nameClass.class.php";

    }  
);

include $_SERVER['DOCUMENT_ROOT'].'/php/admin/main/lbl.class.php';
include $_SERVER['DOCUMENT_ROOT'].'/php/admin/main/view.function.php';

if (!empty($_GET['f'])){
    
    $fecha_inicio = $_GET['f'] ;
    $datos_agenda = datosAgenda($fecha_inicio);
    $ids_existentes = json_decode(stripslashes($_GET['ids']));
    main\view($datos_agenda,$fecha_inicio,$ids_existentes);

}