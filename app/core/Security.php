<?php namespace core ; 

class Security {
    
    private $value  ;

    function __construct( ) {
        
    }

    public static function session () {

        if (isset($_SESSION['id_usuario'])){
            $return = true ;
        } else {
            header('location: login' ) ;
            exit; 
        }
    

        return $return;
        
    }

    public static function scape (Conexion $conn) {
        
    }

    public static function destroy_session () {

        // Borra todas las variables de sesión 
        $_SESSION = array();
    
        // Borra la cookie que almacena la sesión 
        setcookie("PHPSESSID","", time() - 3600);
        setcookie("marca","", time() - 3600, "/");
        setcookie("id_user","", time() - 3600, "/");

        // Finalmente, destruye la sesión 
        session_destroy(); 
        session_start ();
    }

    function  __destruct(){
        
    }
}