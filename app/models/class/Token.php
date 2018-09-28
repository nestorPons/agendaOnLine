<?php namespace models;

class Token extends \core\BaseClass {
    private $id, $selector, $validator, $idUser, $pin, $token; 

    function __CONSTRUCT(string $token = null ){
        if(isset($_COOKIE['auth'])){
            $this->token = $_COOKIE['auth']; 
            $this->
        }
    }
}