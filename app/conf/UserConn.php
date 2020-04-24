<?php namespace conf;
/**
 * Archivo de configuración de la conexión a a la base de datos 
 * ¡IMPORTANTE! ESTA INCLUIDA EN EL GITIGNORE
 */
class UserConn{
    protected 
        $server = 'db', # Cambiar por localhost para servidores remotos
        $user, 
        $pass, 
        $type = 'mysql', 
        $db;
        
    
    protected function user(){
        
        $this->user = 'root';
        $this->pass = 'test';
        
    }
    protected function create(){
        
        $this->user = 'root';
        $this->pass = 'test';

    }
    protected function select(){

        $this->user = 'root';
        $this->pass = 'test';

    }

    protected function createDemo(){

        $this->user = 'root';
        $this->pass = 'test';

    }
}
