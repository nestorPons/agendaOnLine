<?php
require_once $url_base . 'app/conf/autoload.php' ;
$Security = new \core\Security;
$Forms = new models\Forms;
$exceptions = ['fileLogo'];
if (!$Forms->validateForm($_POST, $exceptions)) core\Error::die();

//compruebo que sea dir app

$controller = isset($_REQUEST['controller'])&&$_REQUEST['controller']!='err'
    ?$_REQUEST['controller']
    :'login' ;

if (isset($_GET['empresa'])){

    if (file_exists(URL_EMPRESA)){
    
        require_once $url_base . 'app/conf/config.php' ;
        require_once URL_FUNCTIONS . 'compilaLess.php' ;
        if(!$Security->checkSession($controller)) {
            $controller = 'logout';
            $mensErr = \core\Error::E010;
        }
    
        require  URL_CONTROLLERS . $controller . '.php';

    }else{

        models\Login::logout();
        include(PUBLIC_FOLDER . "error404.php");

    }

} else {

    require_once URL_SCRIPTS . $controller. '.php';
}
//AKI :: implementar seguridad por eventos
//echo $_SESSION['count']++ ;
