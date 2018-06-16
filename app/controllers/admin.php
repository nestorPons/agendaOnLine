<?php

require_once URL_FUNCTIONS .'tools.php';
require_once URL_SCRIPTS . 'admin.php' ;
require_once URL_TEMPLATES . 'lstClientes.php';

$Horarios = new models\Horarios();
$_SESSION['HORAS'] =  $Horarios->hours();

$Servicios = new core\BaseClass('servicios') ;
$_SESSION['SERVICIOS'] = $Servicios->getAll() ;

$Fam = new core\BaseClass('familias') ;
$_SESSION['FAMILIAS'] = $Fam->getAll() ;

$action =  $_REQUEST['action'] ?? 'main' ;
 
require_once( URL_VIEWS_ADMIN . 'admin.php' ) ;        