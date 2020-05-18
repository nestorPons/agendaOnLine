<?php namespace models;

final class Cita extends \core\BaseClass {
    public $Data , $Cita , $Data_del , $Cita_del ;
    private $data, $exist = false; 
    function __CONSTRUCT(int $id = null){
        $this->Data = new \core\BaseClass('data');
        $this->Cita = new \core\BaseClass('cita');
        if ($id) {
            if ($tmp_data = $this->Data->getById($id)){
                $this->exist = true;
                $tmp_cita = $this->Cita->getBy('idCita',$id);
                $this->Services = new \core\BaseClass('servicios'); 
                foreach ($tmp_cita as $key => $value){
                    $tmp_services[] = $this->Services->getById($value['servicio']); 
                }
                $this->User = new User($tmp_data['idUsuario']); 
                $tmp_user = $this->User->data();
                $this->data = array_merge(
                    ['idCita' => $id],
                    ['cliente' => $tmp_user], 
                    ['servicios' => $tmp_services??null], 
                    $tmp_data
                ); 
            } 
        } else {
            $this->Data_del = parent::__construct('data_del');
            $this->Cita_del = parent::__construct('cita_del');
        }
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
    public function data(array $arg = null){
		if(!is_null($arg)) $this->data = $arg;
		return $this->data;  
	 }
    public function exist(bool $arg = null){
        if(!is_null($arg)) $this->exist = $arg; 
        return $this->exist; 
    }
}