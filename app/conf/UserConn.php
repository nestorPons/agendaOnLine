<?php namespace conf;
/**
 * Archivo de configuración de la conexión a a la base de datos 
 * ¡IMPORTANTE! ESTA INCLUIDA EN EL GITIGNORE
 */
class UserConn{
    protected 
        $server = 'db', // dirección de la conexión al contenedor
        $user, 
        $pass, 
        $type = 'mysql', 
        $db,
        $onlyOneUSer = 'root', // usuario de la base de datos del contenedor
        $onlyOnePass = 'test'; // Pass de la base de datos del contenedor
        
    public function __construct(){

    }
    protected function user(){
        
        $this->user = $this->onlyOneUSer;
        $this->pass = $this->onlyOnePass;
        
    }
    protected function create(){
        
        $this->user = $this->onlyOneUSer;
        $this->pass = $this->onlyOnePass;

    }
    protected function select(){

        $this->user = $this->onlyOneUSer;
        $this->pass = $this->onlyOnePass;

    }

    protected function createDemo(){

        $this->user = $this->onlyOneUSer;
        $this->pass = $this->onlyOnePass;

    }
}
