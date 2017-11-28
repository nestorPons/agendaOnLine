<?php 
$action = 'login' ;
$Login = new \models\Login;

$return = include URL_SCRIPTS . 'validar.php' ;

if ( !empty($return['action']) ) {

    $args = isset($return['args']) ? '/' . $return['args'] :  '' ; 
    $action = $return['action'] . $args ;

}

//var_dump ($return);
header('Location: ' . $action);