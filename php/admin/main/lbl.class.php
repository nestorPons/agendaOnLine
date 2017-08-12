<?php  namespace main;

class Lbl {	
    //datos
    private $id ;
    private $nombre ;
    private $codigos ;
    private $idCodigos ;
    private $obs ; 
    private $tiempo ;
    private $servicios ;

    //position
    private $day ;
    private $hour;
    private $agenda ;

    //tamaño
    private $width;
    private $height;

    public $data = []; 
    public $html = null;
	
    //conexion
    private $conn ; 
    
    function __CONSTRUCT(){

        $this->conn = new \connect\Conexion( 'bd_' . $_SESSION['bd'] );

    }

    public function loadDates($ini , $end = null ) {
        $end  = $end ?? $ini ; 
        $sql = "SELECT D.idCita, A.Id AS idCodigo, A.codigo, D.agenda, D.idUsuario, U.nombre, D.obs, D.hora , D.fecha ,A.tiempo, A.descripcion
            FROM cita C JOIN data D ON C.idCita = D.idCita 
            INNER JOIN usuarios	U ON D.idUsuario = U.Id 
            LEFT JOIN articulos A ON C.Servicio = A.Id  
            WHERE D.fecha BETWEEN '$ini' AND '$end'  
            ORDER BY D.idCita, D.hora";

        $this->data($sql) ;
    }


    private function data ($sql) {
        
        $data=$this->conn->all($sql,MYSQLI_ASSOC);
        if (count($data)>0) {

            for( $i = 0 ; $i < count($data) ; $i++ ){
                if (!isset($datosagenda[$data[$i]['idCita']])){
                    $datosagenda[$data[$i]['idCita']] 
                    = array(
                        'idCita'=>$data[$i]['idCita'],
                        'fecha'=>$data[$i]['fecha'],
                        'hora'=>$data[$i]['hora'],
                        'agenda'=>$data[$i]['agenda'],
                        'obs'=>$data[$i]['obs'],
                        'idUsuario'=>$data[$i]['idUsuario'],
                        'nombre'=>$data[$i]['nombre'],
                        'tiempoTotal' => 0 ,
                        'servicios' => array()
                    );
                }
                $datosagenda[$data[$i]['idCita']]['tiempoTotal'] += (int)$data[$i]['tiempo'] ;
                $datosagenda[$data[$i]['idCita']]['servicios'][] = array(
                    'idCodigo'=>$data[$i]['idCodigo'],
                    'codigo'=>$data[$i]['codigo'],
                    'des'=>$data[$i]['descripcion'],
                    'tiempo'=> $data[$i]['tiempo']
                );
            
            }

            $this->data = $datosagenda ;
            $this->print($datosagenda) ;
        } 
        //RESET TABLA CITA_USER
        //$conn->query("TRUNCATE user_reg");

    }

    private function tiempoTotal ($servicios) {

        $tiempoTotal = 0 ;

        foreach ($servicios as $val ){
            $tiempoTotal += (int)$val['tiempo'] ;  
        }

        return $tiempoTotal ;
    }

    private function print ($data) {

        foreach ($data as $val){

            $a = $val['agenda'];

            $id_time = strtotime( $val['fecha'] . " " . $val['hora'] );

            $rows = ceil($this->tiempoTotal($val['servicios']) / 15) ;
            $exten = $rows>1? "extend" :'' ; 
            $show_nota =  empty($this->obs)?'':'show' ;
            $this->html[$id_time][$a] = "
                <div id='".$val['idCita']."' class='lbl row_$rows' >
                    <div id ='".$val['idUsuario']."' class='nombre'>
                        <span class ='icon-user-1'></span> 
                        <!--<span>".$val['idCita']."</span>-->
                        <span>".$val['nombre']."</span>
                    </div>
                    <div class='iconos aling-right'>               
                        <span class ='edit icon-pencil-1'></span>  
                        <span class ='del icon-trash'></span>  
                        <span class =''></span>  
                    </div>
                    <div class='servicios $rows'>          
                        ".$this->printArt($val['servicios'])."                   
                    
                    </div> 
                    <div class='note '>".$this->printNote($val['obs'])."</div> 											  
                </div>
                ";
	    }
    }

    private function printArt($arr){
        $str = '';
        foreach ($arr as $key => $val ){

            $str .= "<div><span class ='icon-angle-right'></span><span class='codigo' des_codigo = '". $val['des'] ."' id_codigo = '". $val['idCodigo']."' tiempo = '". $val['tiempo']."'> ".$val['codigo']."</span></div>";
        }
    
        return $str;
    }

    private function printNote($obs){
        if (!empty($obs)){
            $html = "
                <span class ='icon-note'></span> 
                <span class ='note'>$obs</span>
                <span class='iconClass-inside icon-load  animate-spin'></span>
                <span class='iconClass-inside icon-ok'></span>
            " ; 
        }else{
            $html = '';
        }

        return $html ; 
    }

    public function del () {

        $sql  = 'INSERT INTO del_data (idCita,agenda,idUsuario,fecha,hora,obs,UsuarioCogeCita) SELECT idCita,agenda,idUsuario,fecha,hora,obs,UsuarioCogeCita FROM data WHERE idCita = '.$this->idCita.'; ';
        $sql .= 'INSERT INTO del_cita (Id,idCita,Servicio) SELECT Id, idCita, Servicio FROM cita WHERE idCita = '.$this->idCita.'; ';
        $sql .= 'DELETE FROM data WHERE idCita = '.$this->idCita.'; ';
        $sql .= 'DELETE FROM cita WHERE idCita = '.$this->idCita.'; ';

        return $this->conn->multi_query($sql) ;
    }

    public function edit ($idCita) {

        $sql = "UPDATE data 
            SET idUsuario='$this->user', obs='$this->note' , agenda = $this->agenda , fecha ='$this->fecha' , hora = '$this->hora' 
            WHERE idCita=$this->idCita ; ";
        $sql .=	"DELETE FROM cita WHERE idCita = $this->idCita ;" ;
        foreach ( $ser as $key => $val ) {
            $sql .= "INSERT INTO cita ( idCita, Servicio ) VALUES ( $this->idCita , $val );";
          }
        
        return $this->conn->multi_query($sql) ;
    }

}