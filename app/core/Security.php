<?php namespace core ; 

class Security {
    
    private $value, $status, $browser, $idUser, $keyPass ="undato" ;
    public $attempt;
    //private check exceptions
    private $pageExcep = ['validar','login'];

    function __construct(){
        $this->session_start();
    }
    public function checkSession($pageIn){
  
        return !in_array($pageIn, $this->pageExcep)
            ?isset($_SESSION)
                &&$_SESSION['SKey']==$_COOKIE['token']
                &&$_SESSION['agent']==$_SERVER['HTTP_USER_AGENT']
                &&$_SESSION['ip'] == $_SERVER['REMOTE_ADDR']   
                &&$_SESSION['device'] == self::getDevice()
            :true;  
         
    }
    public function logout() {

        // Borra la cookie que almacena la sesión 
        foreach($_COOKIE as $key => $val){
            setcookie($key, '', time() - 3600, '/');    
        }
        
        // Borra todas las variables de sesión 

        $_COOKIE = array();
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruye la sesión 
        session_destroy(); 
    }
    public function getDevice(){
        return sha1($_SERVER['HTTP_USER_AGENT'] . $_SERVER["HTTP_USER_AGENT"]);
    }    
    public static function session_start(){ 

        /* Establecemos que las paginas no pueden ser cacheadas */
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        

        // Esto detiene JavaScript poder acceder al identificador de sesión. 
        $httponly  =  true ; 
        // obliga a utilizar sólo las cookies. 
        if  ( ini_set ( 'session.use_only_cookies' ,  1 )  ===  false )  { 
            $this->error;
            exit() ; 
        } 
        // Obtiene las cookies actuales params. 
        $cookieParams  =  session_get_cookie_params() ; 
        session_set_cookie_params ( 
            $cookieParams [ "lifetime" ] ,  
            $cookieParams [ "path" ] ,  
            $cookieParams [ "domain" ] ,  
            false ,  
            $httponly 
        ) ; 
        // Establece el nombre de la sesión a la establecida anteriormente. 
       
        session_name (self::getDevice()); 
        session_start(['cookie_lifetime' => 3600 * 8/*h*/,]); // Iniciar la sesión PHP 8 horas expira la session
        session_regenerate_id(true);      // regenerado la sesión, elimine el antiguo. 
  
    }
    public function loadSession($idUser,$company, $admin=0 ){

        $_SESSION['id_usuario'] = $idUser;
        $_SESSION['bd'] =$company ; 
        $_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['admin_sesion']= $admin;
        $_SESSION['SKey'] = bin2hex(random_bytes(20));
        self::cookieToken($_SESSION['SKey']);

        $_SESSION['LastActivity'] =$_SERVER['REQUEST_TIME'];
        $_SESSION['device'] = self::getDevice();

        // AKI ::  hay que implementarlo
        $_SESSION['count'] = 0 ; 

    }
    private static function cookieToken($salt){
        setcookie("token", $salt , 0,'/');
    }
    function  __destruct(){       
    }
}