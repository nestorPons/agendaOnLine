<?php namespace models;

class Agendas extends \core\BaseClass {
   public $max ;
   private $table = 'agendas';
    function __CONSTRUCT(){
        parent::__construct($this->table);
        
    }
}