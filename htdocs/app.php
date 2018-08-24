<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Establecemos zona horaria por defecto
date_default_timezone_set('Europe/Madrid');
//Se inicia session que esta en clase segurity
$url_base = str_replace('htdocs', '' , $_SERVER['DOCUMENT_ROOT'] ) ;
//configuracion general 
require_once $url_base . 'app/conf/constants.php' ;
    
require URL_CONTROLLERS . 'main.controller.php';