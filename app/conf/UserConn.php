<?php namespace conf;

class UserConn{
    protected 
        $server = 'db', 
        $user, 
        $pass, 
        $type = 'mysql', 
        $db;
        
    public function __construct(){}
    protected function user(){
        
        $this->user = 'user';
        $this->pass = '0Z8AHyYDKN0hUYik';

    }
    protected function create(){
        
        $this->user = 'create';
        $this->pass = 'UYQsjBRIv6dCVfEz';

    }
    protected function select(){

        $this->user = 'select';
        $this->pass = 'gon3rJGgpCBwksi0';

    }

    protected function createDemo(){

        $this->user = 'demo';
        $this->pass = 'YLot6pyQCwgTjolF';

    }
}
