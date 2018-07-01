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
    private $number_services; 

    //position
    private $day ;
    private $hour;
    private $agenda ;

    //tamaño
    private $width;
    private $height;

    //publicas
    public $html = null;
    public $data = []; 
    public $ids = [];
	
    //conexion
    private $conn ; 
    
    //objects
    private $dir_container = URL_TEMPLATES . 'lbl/container.php' ; 
    private $dir_row_code = URL_TEMPLATES . 'lbl/code.php' ; 
    private $dir_note =  URL_TEMPLATES . 'lbl/note.php' ; 
    
    function __CONSTRUCT(){

        $this->conn = new \core\Conexion(NAME_DB);

    }
    public function getById ($value) {
        $sql = "SELECT D.id AS idCita, U.id AS idUsuario, A.id AS idCodigo, A.codigo, D.agenda, U.nombre, D.obs, D.hora , D.fecha, D.lastMod ,A.tiempo, A.descripcion, D.tiempo_servicios
            FROM cita C JOIN data D ON C.idCita = D.id 
            INNER JOIN usuarios	U ON D.idUsuario = U.id 
            LEFT JOIN servicios A ON C.servicio = A.id 
            WHERE idCita = '$value';";

        $this->data($sql) ;
        return $this->data;
    }
    public function loadDates( $ini , $end = null , $agenda = null) {
        $end  = $end ?? $ini ; 
        $filter = $agenda!=null?"D.agenda = $agenda AND":"";

        $sql = "SELECT D.id AS idCita, U.id AS idUsuario, A.id AS idCodigo, A.codigo, D.agenda, U.nombre, D.obs, D.hora , D.fecha, D.lastMod ,A.tiempo, A.descripcion, D.tiempo_servicios
                FROM cita C JOIN data D ON C.idCita = D.id 
                INNER JOIN usuarios	U ON D.idUsuario = U.id 
                LEFT JOIN servicios A ON C.servicio = A.id
                WHERE $filter D.fecha BETWEEN '$ini' AND '$end'  
                ORDER BY D.id, D.hora;";

        $this->data($sql) ;
    }
    private function data ($sql) {
        $idLast = 0 ;
        $data=$this->conn->all($sql,MYSQLI_ASSOC);

        if (count($data)>0) {

            for( $i = 0 ; $i < count($data) ; $i++ ){

                if (!isset($datosagenda[$data[$i]['idCita']])){
 
                    $datosagenda[$data[$i]['idCita']] 
                    = array(
                        'idCita'=>$data[$i]['idCita'],
                        'fecha'=>$data[$i]['fecha'],
                        'hora'=>$data[$i]['hora'],
                        'lastMod'=> $data[$i]['lastMod'],
                        'agenda'=>$data[$i]['agenda'],
                        'obs'=>$data[$i]['obs'],
                        'idUsuario'=>$data[$i]['idUsuario'],
                        'nombre'=>$data[$i]['nombre'],
                        'tiempoTotal' => $data[$i]['tiempo_servicios'], 
                        'servicios' => array()
                    );
                }
                $datosagenda[$data[$i]['idCita']]['servicios'][] = array(
                    'idCodigo'=>$data[$i]['idCodigo'],
                    'codigo'=>$data[$i]['codigo'],
                    'des'=>$data[$i]['descripcion'],
                    'tiempo'=> $data[$i]['tiempo']
                );

                //Se devuelven ids de la citas para control de cambios o lo que surja 
                if($data[$i]['idCita']!=$idLast) $this->ids[$data[$i]['fecha']][] = $data[$i]['idCita'];
                $idLast = $data[$i]['idCita'];
            }

            $this->data = $datosagenda ;
            $this->print($datosagenda) ;
        } 
        
    }

    private function print ($data) {

        foreach ($data as $val){

            $a = $val['agenda'];

            $id_time = strtotime( $val['fecha'] . " " . $val['hora'] );

            $rows = ceil($val['tiempoTotal'] / 15) ;

            $exten = $rows>1? "extend" :'' ; 
            $show_nota =  empty($this->obs)?'':'show' ;
            $servicies = $this->printArt($val['servicios']) ; 
            $number_services = $this->number_services;
            $note = $this->printNote($val['obs']) ;

            ob_start();
            require $this->dir_container ; 
            $this->html[$id_time][$a] = ob_get_clean();

	    }
        
    }
    private function printArt($arr){
        $str = '';
        $s = 0 ;
        foreach ($arr as $key => $val ){
            $s++; 
            ob_start();
            require $this->dir_row_code ; 
            $str .= ob_get_clean();
        }
        $this->number_services = $s;
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