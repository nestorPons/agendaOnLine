<?php  namespace agendas;
class Lbl {	
    //datos
    private $id ;
    private $nombre ;
    private $codigos ;
    private $idCodigos ;
    private $obs ; 
    //position
    private $day ;
    private $hour;
    private $agenda ;

    //tamaño
    private $width;
    private $height;

    //estado
    public $status = false ;
    public $html = null;
	
    function __CONSTRUCT($datos){
        if (!empty($datos)){
            $this->idCita = $datos['idCita'] ;
            $this->nombre = $datos['nombre'] ;
            $this->idCodigos = $datos['idCodigo'] ;
            $this->codigos = $datos['codigo'] ;
            $this->des = $datos['des'] ;
            $this->obs = $datos['obs'] ;
            //$this->day = $datos['dia'] ; 
            //$this->hour = $datos['hora'] ;
            $this->agenda = $datos['agenda'] ;
            $this->tiempo = $datos['tiempo'] ;
            $this->paint() ;
            $this->status = true ; 
        }else{
            $this->status = false ; 
        }
    }

    private function paint () {
        $rows = ceil($this->tiempo / 15) ;
        $exten = $rows>1? "extend" :'' ; 
        $show_nota =  empty($this->obs)?'':'show' ;
        $this->html = "
            <div id='".$this->idCita."' class='lbl row_$rows' >
                <div class='nombre'>
                    <!--<span class ='icon-user-1'></span> -->
                    <span>$this->idCita</span>
                    <span>$this->nombre</span>
                </div>
                <div class='iconos aling-right'>               
                    <span class ='edit icon-pencil-1'></span>  
                    <span class ='del icon-trash'></span>  
                    <span class =''></span>  
                </div>
                <div class='servicios $exten'>          
                    ".$this->printArt($this->codigos)."                   
                   
                </div> 
                <div class='note '>
                   ". $this->printNote() ."
                </div> 											  
            </div>
            ";
    }

    private function printArt($arr){
        $str = '';
        for ($i = 0 ; $i <  count($arr) ; $i++){
            $str .= "<div><span class ='icon-angle-right'></span><span class='codigo' des_codigo = '". $this->des[$i]."' id_codigo = '". $this->idCodigos[$i]."' tiempo = '". $this->tiempo[$i]."'> ".$arr[$i]."</span></div>";
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

}