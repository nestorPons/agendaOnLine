<?php

if(!isset($_COOKIE["auth"])||isset($_GET['logout'])){

    $Security->logout();
    $Security->session_start();
    require_once URL_VIEWS . 'login.php';

} else {

    $Login = new \models\Login;
    $action =
        $Login->authToken($_COOKIE["auth"])
            ? $Login->createSession()
            :'error';


   header('Location: ' . NAME_EMPRESA . '/' . $action);
}
