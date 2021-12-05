<?php namespace conf;

class UserConn{
    protected 
        $server, 
        $user, 
        $pass, 
        $type, 
        $db;
        
    public function __construct(){
        $this->server = $_ENV['DATABASE_HOST'];
        $this->type = $_ENV['DATABASE_TYPE'];
    }
    protected function user(){
        $this->user = $_ENV['DATABASE_USER_USER_NAME'];
        $this->pass = $_ENV['DATABASE_USER_USER_PASS'];
    }
    protected function create(){
        $this->user = $_ENV['DATABASE_USER_CREATE_NAME'];
        $this->pass = $_ENV['DATABASE_USER_CREATE_PASS'];
    }
    protected function select(){
        $this->user = $_ENV['DATABASE_USER_SELECT_NAME'];
        $this->pass = $_ENV['DATABASE_USER_SELECT_PASS'];
    }
    protected function createDemo(){
        $this->user = $_ENV['DATABASE_USER_DEMO_NAME'];
        $this->pass = $_ENV['DATABASE_USER_DEMO_PASS'];
    }
}