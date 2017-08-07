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

    
    public $html = null;
	
    //conexion
    private $conn ; 
    
    function __CONSTRUCT($datos){

        $this->idCita = $datos['idCita'] ;
        $this->nombre = $datos['nombre'] ;
        $this->idUsuario = $datos['idUsuario'] ;
        $this->servicios = $datos['servicios'] ;
        
        $this->obs = $datos['obs'] ;
        $this->agenda = $datos['agenda'] ;

    }

    private function conexion() {
        $this->conn = new \connect\Conexion( 'bd_' . $_SESSION['bd'] );
    }

    private function tiempoTotal ($arr_servicios = 0 ) {
        $tiempoTotal = 0 ;

        foreach ($this->servicios as $key => $val ){
            $tiempoTotal += (int)$val['tiempo'] ;  
        }
        return $tiempoTotal ;
    }

    public function paint () {

        $rows = ceil($this->tiempoTotal() / 15) ;
        $exten = $rows>1? "extend" :'' ; 
        $show_nota =  empty($this->obs)?'':'show' ;
        $this->html = "
            <div id='".$this->idCita."' class='lbl row_$rows' >
                <div id =' $this->idUsuario ' class='nombre'>
                    <span class ='icon-user-1'></span> 
                    <!--<span>$this->idCita</span>-->
                    <span>$this->nombre</span>
                </div>
                <div class='iconos aling-right'>               
                    <span class ='edit icon-pencil-1'></span>  
                    <span class ='del icon-trash'></span>  
                    <span class =''></span>  
                </div>
                <div class='servicios $exten'>          
                    ".$this->printArt($this->servicios)."                   
                
                </div> 
                <div class='note '>
                ". $this->printNote() ."
                </div> 											  
            </div>
            ";
        return $this->html ;

    }

    private function printArt($arr){
        $str = '';
        foreach ($arr as $key => $val ){

            $str .= "<div><span class ='icon-angle-right'></span><span class='codigo' des_codigo = '". $val['des'] ."' id_codigo = '". $val['idCodigo']."' tiempo = '". $val['tiempo']."'> ".$val['codigo']."</span></div>";
        }
    
        return $str;
    }

//AKI :: diseñando la forma de enseñar las notas

    private function printNote(){
        if (!empty($this->obs)){
            $html = "
                <span class ='icon-note'></span> 
                <span class ='note'>$this->obs</span>
                <span class='iconClass-inside icon-load  animate-spin'></span>
                <span class='iconClass-inside icon-ok'></span>
            " ; 
        }else{
            $html = '';
        }

        return $html ; 
    }

    public function del () {

        $this->conexion() ; 

        $sql  = 'INSERT INTO del_data (IdCita,Agenda,IdUsuario,Fecha,Hora,Obs,UsuarioCogeCita) SELECT IdCita,Agenda,IdUsuario,Fecha,Hora,Obs,UsuarioCogeCita FROM data WHERE IdCita = '.$this->idCita.'; ';
        $sql .= 'INSERT INTO del_cita (Id,IdCita,Servicio) SELECT Id, IdCita, Servicio FROM cita WHERE IdCita = '.$this->idCita.'; ';
        $sql .= 'DELETE FROM data WHERE IdCita = '.$this->idCita.'; ';
        $sql .= 'DELETE FROM cita WHERE IdCita = '.$this->idCita.'; ';

        return $this->conn->multi_query($sql) ;
    }

    public function edit () {
        
        $this->conexion() ; 

        $sql = "UPDATE data 
            SET IdUsuario='$this->user', Obs='$this->note' , Agenda = $this->agenda , Fecha ='$this->fecha' , Hora = '$this->hora' 
            WHERE IdCita=$this->idCita ; ";
        $sql .=	"DELETE FROM cita WHERE idCita = $this->idCita ;" ;
        foreach ( $ser as $key => $val ) {
            $sql .= "INSERT INTO cita ( IdCita, Servicio ) VALUES ( $this->idCita , $val );";
          }
        
        return $this->conn->multi_query($sql) ;
    }

}