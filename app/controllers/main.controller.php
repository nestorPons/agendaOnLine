<?php

try {
    require_once $url_base . 'app/conf/autoload.php' ;
    $Security = new \core\Security;
    $Forms = new models\Forms($_POST, ['fileLogo','tel','chck']);

    //compruebo que sea dir app
    $controller = isset($_REQUEST['controller'])&&$_REQUEST['controller']!='err'
        ?$_REQUEST['controller']
        :'login' ;

    //Inicializo la base datos DEMO para ejemplos
    if(isset($_REQUEST['empresa']) && $_REQUEST['empresa']==='demo' && $controller=='login'){
        models\Login::example();
    }
    
    
    // Condicion para cuando la empresa no esta creada no cargue la configuracion  de la empresa 
    if (isset($_REQUEST['empresa'])) require_once $url_base . 'app/conf/config.php' ;
    if (isset($_GET['empresa'])){
        $Logs = new models\Logs;
        if (file_exists(URL_EMPRESA)){     
            require_once URL_FUNCTIONS . 'compilaLess.php' ;

            if(!$Security->checkSession($controller)) {
                $controller = 'logout';
                $mensErr = \core\Error::E010;
                exit();
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
 } 
catch (\Exception $e) {
    die($e->getMessage() . "::" . $e->getFile() . "::" . $e->getLine());
 }