<?php 
$User = new \models\User($_SESSION['id_usuario']); 
$Agendas = new \models\Agendas($User->isUser()); 

if ($User->isAdmin()){
    $cls_users = new core\BaseClass('usuarios') ;
    $users  = $cls_users->getAll( '*' ,  MYSQLI_ASSOC  ) ;
} 
$fecha = $_GET['fecha'] ?? date('Y-m-d') ;

require_once URL_VIEWS_ADMIN . 'crearCita.php' ; 