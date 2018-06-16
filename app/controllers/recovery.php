<?php namespace models;
if($_POST){
    
} else if(isset($_GET['args'])){
    $idUser = substr($_GET['args'],-4);
    
    $User = new User($idUser);
    require URL_VIEWS . 'login/recovery.php';
} else {
    $mensErr = \core\Error::E010;
    header('location: /'.CODE_EMPRESA . '/err/'.$mensErr);
}