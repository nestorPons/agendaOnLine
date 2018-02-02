<?php 
$Agendas = new core\BaseClass('agendas');
$agendas  = isset($zoneUsers)?$Agendas->getBy('mostrar', 1, '*' , MYSQLI_NUM ):$Agendas->getAll();

if ( !isset($zoneUsers)){
    $cls_users = new core\BaseClass('usuarios') ;
    $users  = $cls_users->getAll( '*' ,  MYSQLI_ASSOC  ) ;
}
$fecha = $_GET['fecha'] ?? date('Y-m-d') ;

require_once URL_VIEWS_ADMIN . 'crearCita.php' ; 