<?php namespace models;

class Agendas extends \core\BaseClass {
   public $max, $get;
   private $isZoneUsers;
   
   private $table = 'agendas';
    function __CONSTRUCT($isZoneUser = false){
        parent::__construct($this->table);
        $this->isZoneUsers = $isZoneUser; 
        $this->get = $this->get();
    }
    function get(){
        return ($this->isZoneUsers) ? $this->getBy('mostrar', 1, '*' , MYSQLI_NUM ) : $this->getAll();
    }
}