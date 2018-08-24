<?php 
$idUser = substr($_GET['args'],-4);
$User = new models\User($idUser);

$args =  ($User->statusActive($_GET)) ? '?success=Usuario activado con exito' : '?error=' .\core\Error::$last; 
header('location:'. '/'.$Empresa->code(). $args);