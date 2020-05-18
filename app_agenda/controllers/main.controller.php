<?php 

try {
    
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
        
        $Empresa = new models\Empresa('lebouquet');
        require_once $FOLDER_CONFIG .'config.php' ;
    
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
            
        
    //AKI :: implementar seguridad por eventos
    //echo $_SESSION['count']++ ;
} catch (\Exception $e) {
    echo 'controlador = ' . $controller . BR ; 
    die($e->getMessage() . "::" . $e->getFile() . "::" . $e->getLine());

 }