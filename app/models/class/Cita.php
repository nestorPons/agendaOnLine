<?php namespace models;

class Cita extends \core\BaseClass {
    private $table = 'data';

    function __CONSTRUCT(){
       parent::__construct($this->table);
    }

    public function deleteById ( $id ) {
        $sql='UPDATE servicios  SET Baja = 1 WHERE id='.$id .' LIMIT 1;';
        return $this->conn->query($sql);
    }

}