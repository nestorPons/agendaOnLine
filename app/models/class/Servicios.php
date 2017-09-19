<?php namespace models;

class Servicios extends \core\BaseClass {
    private $table = 'servicios';

    function __CONSTRUCT(){
       parent::__construct($this->table);
    }

    public function deleteById ( $id ) {
        $sql='UPDATE servicios  SET Baja = 1 WHERE id='.$id .' LIMIT 1;';
        return $this->conn->query($sql);
    }

}