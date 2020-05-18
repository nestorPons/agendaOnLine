<?php namespace models;

final class Agendas extends \core\BaseClass {
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
    function add($max_permitted, string $arg = null){
        
        $name = $arg??"Agenda". ($this->count()+1); 

        return ($this->count <= $max_permitted)
             ? $this->saveById(-1, ["nombre"=> $name])
             : false; 
    }
    function del($id){
        $horarios = new Horarios; 
        return ($horarios->delByAgenda($id))? $this->deleteById($id) : false;
    }
    function count(){
        return $this->count;
    }
}