<?php namespace core ; 

class Security {
    const ISINT = 1 , ISBOOL = 2, ISSTR = 3, ISDATE = 4, ISEMAIL = 5;
    private $value, $status, $browser, $idUser, $keyPass ="undato" ;
    public $attempt;
    //private check exceptions
    private $pageExcep = ['validar','login'];
    private  $rules =  [
                'agenda'    => [self::ISINT,2],
                'action'    => [self::ISSTR,6],
                'controler' => [self::ISSTR,16],
                'cp'        => [self::ISINT,6],
                'dir'       => [self::ISSTR,50],
                'dni'       => [self::ISSTR,10],
                'email'     => [self::ISEMAIL,50],
                'fecha'     => [self::ISDATE,10],
                'nombre'    => [self::ISSTR,50],
                'cliente'   => [self::ISSTR,50],  
                'poblacion' => [self::ISSTR,30],
                'provincia' => [self::ISSTR,30],
                'pais'      => [self::ISSTR,30],
                'tel'       => [self::ISSTR,15], 
                'web'       => [self::ISSTR,50],
            ];

    function __construct(){
        $this->session_start();
    }
      
    public static function sanitize($post){
        if(isset($post['controller'])) unset($post['controller']);
        if(isset($post['action'])) unset($post['action']);
        return $post;
    }
    public function validateForm ($post,$exceptions = []){

        foreach($post as $key => $value){
            if (empty($value) && !in_array($key, $exceptions)) return false;
            foreach ($this->rules as $kRule => $vRule){
                if (strstr($key,$kRule)){
                    
                    if(strlen($value)>$vRule[1]) return false;

                    switch($vRule[0]){
                        case self::ISSTR:
                            
                            break;
                        case self::ISINT:
                            if(!filter_var($value, FILTER_VALIDATE_INT)) return false;
                            break;
                        case self::ISDATE:
                            if (!$this->isDate($value)) return false;
                            break;
                        case self::ISEMAIL:
                            if (!filter_var($value, FILTER_SANITIZE_EMAIL)) return false;
                            break;
                    }   
                     
                    break;
                }
            
            }
        }
        return true;
    }  
    public static function isDate($strDate){
        $arr = explode('-',$strDate);
        return checkdate($arr[1],$arr[2],$arr[0]);
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
    public static function requestScape($request, $conn){
        
        foreach ($request as $key => $value) {

            if (is_array($value)){
                foreach ( $value as $k => $val ) { 
                    if (is_array($val)){
                        foreach ( $val as $h => $v ) { 
                            
                            $request[$key][$k][$h] = $conn->scape($v) ;

                        }

                    }else{

                        $request[$key][$k] = $conn->scape($val) ;

                    }

                }

            }else{
            $request[$key] = $conn->scape($value) ;
    
            }

        }
        
    }
    function  __destruct(){       
    }
}