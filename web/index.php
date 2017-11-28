<?php 
//Establecemos zona horaria por defecto
date_default_timezone_set('Europe/Madrid');
//Se inicia session que esta en clase segurity
$url_base = str_replace('web', '' , $_SERVER['DOCUMENT_ROOT'] ) ;
//configuracion general 
require_once $url_base . 'app/conf/constants.php' ;
require_once $url_base . 'app/conf/autoload.php' ;

$Security = new \core\Security;

require_once $url_base . 'app/conf/config.php' ;
require_once URL_SOURCES . 'compilaLess.php' ;

$controller = isset($_REQUEST['controller'])
    ?$_REQUEST['controller']
    :'login' ;
$controller = $Security->checkSession($controller)
    ?$controller
    :'error';
//echo $_SESSION['count']++ ;

$urlController = URL_CONTROLLERS . $controller . '.php';

if (file_exists($urlController)){

        require $urlController;
}else{
    $Security->logout();
    header("HTTP/1.0 404 Not Found");
}