<?php namespace models;

if(isset($_GET['args'])){
    $idUser = substr($_GET['args'],-4);
    
    $User = new User($idUser);
    require URL_VIEWS . 'login/recovery.php';
} else {
    $mensErr = \core\Error::E010;
    header('location: /'.$Empresa->code() . '/err/'.$mensErr);
}