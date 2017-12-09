<?php
require_once $url_base . 'app/conf/autoload.php' ;
$Security = new \core\Security;

//compruebo que sea dir app

$controller = isset($_REQUEST['controller'])
    ?$_REQUEST['controller']
    :'login' ;

if (isset($_GET['empresa'])){

    if (file_exists(URL_EMPRESA)){

        require_once $url_base . 'app/conf/config.php' ;
        require_once URL_FUNCTIONS . 'compilaLess.php' ;
        $controller = $Security->checkSession($controller)
            ?$controller
            :'error';
        $urlController = URL_CONTROLLERS . $controller . '.php';
        require $urlController;

    }else{

        $Security->logout();

        include(PUBLIC_FOLDER . "error404.php");

    }

} else {

    require_once URL_SCRIPTS . $controller. '.php';
}
//AKI :: implementar seguridad por eventos
//echo $_SESSION['count']++ ;
