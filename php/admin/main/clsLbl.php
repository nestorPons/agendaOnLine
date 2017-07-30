<?php  namespace main;

class Lbl {	
    //datos
    private $id ;
    private $nombre ;
    private $codigos ;
    private $idCodigos ;
    private $obs ; 
    private $tiempo ;
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
            $this->idUsuario = $datos['idUsuario'] ;
            $this->servicios = $datos['servicios'] ;
            
            $this->obs = $datos['obs'] ;
            $this->agenda = $datos['agenda'] ;
        
            $this->tiempoTotal = $datos['tiempo_total'] ;
            $this->paint() ;    
            $this->status = true ; 
        }else{
            $this->status = false ; 
        }
    }

    private function paint () {
        $rows = ceil($this->tiempoTotal / 15) ;
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

}