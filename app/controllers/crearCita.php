<?php 
require_once $_SESSION['FILE_CONFIG']  ;
require_once URL_FUNCTIONS . 'tools.php'  ;

$Agendas = new core\BaseClass('agendas') ;
$agendas  = isset($zoneUsers)?$Agendas->getBy('mostrar', 1, '*' , MYSQLI_NUM ):$Agendas->getAll();

$cls_users = new core\BaseClass('usuarios') ;
$users  = $cls_users->getAll( '*' ,  MYSQLI_ASSOC  ) ;

$fecha = $_GET['fecha'] ?? date('Y-m-d') ;

require_once URL_VIEWS_ADMIN . 'crearCita.php' ; 