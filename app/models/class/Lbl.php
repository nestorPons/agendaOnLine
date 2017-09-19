<?php  namespace models;

class Lbl {	

    //datos
    private $id ;
    private $idCita ; 
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
    
    //object
    private $dir_container = URL_TEMPLATES . 'lbl/container.php' ; 
    private $dir_row_code = URL_TEMPLATES . 'lbl/code.php' ; 
    private $dir_note =  URL_TEMPLATES . 'lbl/note.php' ; 
    
    function __CONSTRUCT(){

        $this->conn = new \core\Conexion( 'bd_' . $_SESSION['bd'] );

    }

    public function loadDates($ini , $end = null ) {
        $end  = $end ?? $ini ; 
        $sql = "SELECT D.id AS idCita, U.id AS idUsuario, A.id AS idCodigo, A.codigo, D.agenda, U.nombre, D.obs, D.hora , D.fecha ,A.tiempo, A.descripcion
                FROM cita C JOIN data D ON C.idCita = D.id 
                INNER JOIN usuarios	U ON D.idUsuario = U.id 
                LEFT JOIN servicios A ON C.servicio = A.id
                WHERE D.fecha BETWEEN '$ini' AND '$end'  
                ORDER BY D.id, D.hora";

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
        function requireToVar ($file) {
            
            require $file;
            return ob_get_clean();
            
        }
        foreach ($data as $val){

            $a = $val['agenda'];

            $id_time = strtotime( $val['fecha'] . " " . $val['hora'] );

            $rows = ceil($this->tiempoTotal($val['servicios']) / 15) ;
            $exten = $rows>1? "extend" :'' ; 
            $show_nota =  empty($this->obs)?'':'show' ;
            $servicies = $this->printArt($val['servicios']) ; 
            $note = $this->printNote($val['obs']) ;

            ob_start();
            require $this->dir_container ; 
            $this->html[$id_time][$a] = ob_get_clean();

	    }
    }

    private function printArt($arr){
        $str = '';

        foreach ($arr as $key => $val ){
            ob_start();
            require $this->dir_row_code ; 
            $str .= ob_get_clean();
        }
    
        return $str;
    }

    private function printNote($obs){
        if (!empty($obs)){
            ob_start();
            require $this->dir_note ;
            $html = ob_get_clean() ;
        }else{
            $html = '';
        }

        return $html ; 
    }
    public function add () {
        
    }   

    public function  del ($id) {

        $sql  = 'INSERT INTO del_data (id,agenda,idUsuario,fecha,hora,obs,UsuarioCogeCita) SELECT id,agenda,idUsuario,fecha,hora,obs,UsuarioCogeCita FROM data WHERE id = '.$id.'; ';
        $sql .= 'INSERT INTO del_cita (id,idCita,Servicio) SELECT id, idCita, Servicio FROM cita WHERE id = '.$id.'; ';
        $sql .= 'DELETE FROM data WHERE id = '.$id.'; ';
        $sql .= 'DELETE FROM cita WHERE idCita = '.$id.'; ';

        return $this->conn->multi_query($sql) ;
    }

    public function edit ($idCita) {

        $sql = "UPDATE data 
            SET idUsuario='$this->user', obs='$this->note' , agenda = $this->agenda , fecha ='$this->fecha' , hora = '$this->hora' 
            WHERE id = $this->idCita ; ";
        $sql .=	"DELETE FROM cita WHERE idCita = $this->idCita ;" ;
        foreach ( $ser as $key => $val ) {
            $sql .= "INSERT INTO cita ( idCita, Servicio ) VALUES ( $this->idCita , $val );";
          }
        
        return $this->conn->multi_query($sql) ;
    }

}