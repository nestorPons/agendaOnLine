<?php namespace models;

class Agendas extends \core\BaseClass {
   public $count;
   private $isZoneUsers, $get;

    function __CONSTRUCT($isZoneUser = false){
        $this->table = 'agendas';
        parent::__construct($this->table);
        $this->count = parent::count();
        $this->isZoneUsers = $isZoneUser; 
        $this->get = ($this->isZoneUsers) ? $this->getBy('mostrar', 1, '*' , MYSQLI_NUM ) : $this->getAll();
    }
    function get(){
        return $this->get;
    }
    function add($max_permitted){

        return ($this->count < $max_permitted)
             ? $this->saveById(-1, ["nombre"=>"Agenda". ($this->count()+1)])
             : false; 
    }
    function count(){
        return $this->count;
    }
}