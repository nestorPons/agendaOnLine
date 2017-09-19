<?php 
session_start() ;

$arr = explode('/', $_SERVER['DOCUMENT_ROOT'] ) ;
require_once( str_replace(array_pop($arr),'',$_SERVER['DOCUMENT_ROOT']) . '/app/conf/config.php' );

include_once URL_SOURCES . 'compilaLess.php' ;

$controller = $_REQUEST['controller'] ?? 'login' ;
require_once URL_CONTROLLERS . $controller . '.php' ;
