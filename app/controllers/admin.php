<?php
 
core\Security::session() ;
   
require_once URL_FUNCTIONS .'tools.php';
require_once URL_SCRIPTS . 'admin.php' ;
require_once URL_TEMPLATES . 'lstClientes.php';

$horarios = new models\Horarios();
$_SESSION['HORAS'] =  $horarios->hours();
$_SESSION['FESTIVOS'] = include_once (URL_SCRIPTS . 'festivos.php') ;

$action =  $_REQUEST['action'] ?? 'main' ;
require_once( URL_VIEWS . 'admin.php' ) ;        
$fecha = $_GET['fecha'] ?? Date('Y-m-d');  