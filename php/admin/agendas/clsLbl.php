<?php 
class Lbl {
	
    private $id ;
    //position
    private $day ;
    private $hour;
    private $agenda ;

    //tamaño
    private $width;
    private $height;

    private $hours ;
    private $rows ;
    private $note ;
	
    function __CONSTRUCT($datos){
        
        //$this->day = $datos['dia'] ; 
        //$this->hour = $datos['hora'] ;
        //$this->agenda = $datos['agenda'] ;
        $this->tiempo = $datos[1]['tiempo'] ;
echo  $this->tiempo;
       // $this->paint(ceil($this->tiempo / 15)) ;

    }

    private function paint () {
        $n = ceil($this->tiempo / 15) ;
        echo "
            <div  class='lbl row_$n'> 
                <span>$n</span>
                <div class='aling-right'>
                    <span class ='edit icon-pencil-1'></span>  
                    <span class ='del icon-trash'></span>  
                    <span class =''></span>  
                </div> 
                <br>
                <span>codigos1 , codigo2 , codigo3</span> <br>
                <span>observaciones</span> <br>												  
            </div>
            ";
    }


}