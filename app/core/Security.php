<?php namespace core ; 

class Security {
    private $value, $status, $browser, $idUser, $keyPass ="undato" ;
    public $attempt;
    private $pageExcep = ['validar','login','activate','recovery'];
    //private check exceptions
   
    function __construct(){
        
        $this->session_start();

     }
    public function checkSession($pageIn){
   /*     
        
       echo "1>>>" .  var_dump(isset($_SESSION)) . BR;
        echo "2>>>" . var_dump(isset($_SESSION['SKey'])) .BR;
        echo "3>>>" . var_dump($_SESSION['SKey']==$_COOKIE['token']) .BR;
        echo "4>>>" .var_dump($_SESSION['agent']==$_SERVER['HTTP_USER_AGENT']).BR;
        echo "5>>>" .var_dump($_SESSION['ip'] == $_SERVER['REMOTE_ADDR']).BR;
        echo "6>>>" .var_dump($_SESSION['device'] == self::getDevice()).BR;
echo BR;
    */
        return !in_array($pageIn, $this->pageExcep)      
            ?isset($_SESSION)
                &&isset($_SESSION['SKey'])
                &&$_SESSION['SKey']==$_COOKIE['token']
                &&$_SESSION['agent']==$_SERVER['HTTP_USER_AGENT']
                //&&$_SESSION['ip'] == $_SERVER['REMOTE_ADDR']   
                &&$_SESSION['device'] == self::getDevice()
            :true;
            
     }
    public static function getDevice(){
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
        session_start(); // Iniciar la sesión PHP 8 horas expira la session
       //session_regenerate_id(true);      // regenerado la sesión, elimine el antiguo. (Da problemas al actualizar los dias de crearcita.horas)

     }
    public function loadSession($idUser,$company, $admin=0 ){
        $_SESSION['ancho'] = $_POST['ancho']; 
        $_SESSION['id_usuario'] = $idUser;
        $_SESSION['bd'] =$company ; 
        $_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['admin_sesion']= $admin;
        $_SESSION['SKey'] = bin2hex(random_bytes(20));
        

        self::cookieToken($_SESSION['SKey']);

        $_SESSION['LastActivity'] =$_SERVER['REQUEST_TIME'];
        $_SESSION['device'] = self::getDevice();

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
    public static function cookieDestroy($name_cookie){
        return setcookie($name_cookie, "", time()-3600);
     }
    function  __destruct(){}
 }