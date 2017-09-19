<?php 

core\Security::session() ;
require_once $_SESSION['FILE_CONFIG']  ;
require_once URL_FUNCTIONS . 'tools.php'  ;

$cls_agendas = new core\BaseClass('agendas') ;
$agendas  = $cls_agendas->getAll( ) ;

$cls_users = new core\BaseClass('usuarios') ;
$users  = $cls_users->getAll( '*' ,  MYSQLI_ASSOC  ) ;

$cls_services = new core\BaseClass('servicios') ;
$services  = $cls_services->getAll( ) ;

$cls_families = new core\BaseClass('familias') ;
$families  = $cls_families->getAll( ) ;

$fecha = $_GET['fecha'] ?? date('Y-m-d') ;

require_once URL_VIEWS . 'crearCita.php' ; 