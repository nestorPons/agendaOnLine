<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Establecemos zona horaria por defecto
date_default_timezone_set('Europe/Madrid');

//Se inicia session que esta en clase segurity
$url_base = str_replace('htdocs', '' , $_SERVER['DOCUMENT_ROOT'] ) ;
$FOLDER_CONFIG = $url_base  . 'app_agenda/conf/'; 
//configuracion general 
require_once $FOLDER_CONFIG  . 'constants.php' ;
require_once  $FOLDER_CONFIG . 'autoload.php' ;
require URL_CONTROLLERS . 'main.controller.php';