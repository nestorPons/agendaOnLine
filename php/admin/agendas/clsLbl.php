<?php  namespace agendas;
class Lbl {
	
    //datos
    private $idCita ;
    private $nombre ;
    private $codigos ;
    private $idCodigos ;

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
        $this->html = "
            <div  class='lbl row_$rows'>
                <div class='nombre'>
                    <span class ='icon-user-1'>$this->idCita</span> 
                    <span>$this->nombre</span>
                </div>
                <div class='iconos aling-right'>
                    <span class ='edit icon-pencil-1'></span>  
                    <span class ='del icon-trash'></span>  
                    <span class =''></span>  
                </div>
                <div class='servicios $exten'>          
                    ".$this->printArr($this->codigos)."                   
                </div> 
                <div>
                     <span class ='icon-note'></span> 
                     <span class =''>$rows</span>
                </div> 											  
            </div>
            ";
    }

    private function printArr($arr){
        $str = '';
        for ($i = 0 ; $i <  count($arr) ; $i++){
            $str .= "<div> <span class ='icon-angle-right'></span><span> ".$arr[$i]."</span></div>";
        }

        return $str;
    }


}