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
        $demo_email = "demo@demo.es"; 
        $demo_pass = "Demo1234"; 
    }

    // LE BOUQUET 
    
    /*    include URL_SCRIPTS . 'exportacion.php';
    exit(0); 
    */
        // Comprobando el GET sabreos si estamos en login
        if(isset($_GET['empresa'])) $_SESSION['empresa'] = $_GET['empresa'];

        // Todos los demas casos que haya pasado por login
        if (isset($_SESSION['empresa'])){

            $Empresa = new models\Empresa($_SESSION['empresa']);
            require_once $url_base . 'app/conf/config.php' ;
      
            $Logs = new models\Logs;

            if (file_exists(URL_EMPRESA)){     
                require_once URL_FUNCTIONS . 'compilaLess.php' ;
           
                if(!$Security->checkSession($controller) && $controller != 'validar') {
                    $Login = new \models\Login; 
                    $Login->logout();
                }
                
                require  URL_CONTROLLERS . $controller . '.php';
                
            }else{
                include(PUBLIC_FOLDER . "error404.php");
                
            }
            
        } else {
            /**
             * Si no he pasado por login voy a scripts (validar y crear nueva empresa)
             */
            require_once URL_SCRIPTS . $controller. '.php';
        }
    //AKI :: implementar seguridad por eventos
    //echo $_SESSION['count']++ ;
} catch (\Exception $e) {
    echo 'controlador = ' . $controller . BR ; 
    die($e->getMessage() . "::" . $e->getFile() . "::" . $e->getLine());

 }