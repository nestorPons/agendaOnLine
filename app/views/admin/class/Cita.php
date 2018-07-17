<?php namespace models;

class Cita extends \core\BaseClass {
   public $Data , $Cita , $Data_del , $Cita_del ;
    function __CONSTRUCT(){
        $this->Data = parent::__construct('data');
        $this->Cita = parent::__construct('cita');
        $this->Data_del = parent::__construct('data_del');
        $this->Cita_del = parent::__construct('cita_del');
    }
    public function add () {
       
        $sql= "INSERT INTO data (agenda,idUsuario,fecha,hora,obs,usuarioCogeCita) 
        VALUE ('$agenda','$userId','$fecha', '$hora' ,'$nota','".$_SESSION['id_usuario']."')";
        return $this->conn->query($sql);
    }
    public function deleteById ( $id ) {
        $sql='UPDATE servicios  SET Baja = 1 WHERE id='.$id .' LIMIT 1;';
        return $this->conn->query($sql);
    }
    public function copyDelTable (int $id_data , int $id_cita = null) {

        $r = $this->Data->copyTableById('del_data', $id_data ) ;
        if ($r){
            $r = $Data->deleteById($idCita);
            $this->Data_del->saveById($id_data, ['fechaDel',date('Y-m-d H:m:s')]); 
        }
        if ($r) 
            $r = $Cita->deleteBy('idCita' , $idCita);
        
        if (isset($id_cita)){
            //true
             $r = $Cita->copyTableBy('del_cita', $idCita , 'idCita' ) ;
        } 
        
    }

}