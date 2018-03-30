<?php namespace models;

class Empresa extends \core\BaseClass {
   private $data, $code, $conf_css, $conf;

    function __construct($codeEmpresa){
        parent::__construct('empresas', 'aa_db', 2);

//AKI :: implementar metodo para crear una session con los datos 
//y no tener que hacer tantas peticiones 
//ademas debera actualizar cadavez que se cambien los datos INSERT o UPDATE

        $this->data = $this->getBySQL("replace(`nombre_empresa`,' ','') = '$codeEmpresa' LIMIT 1",  MYSQLI_ASSOC)[0];         
        $this->code = \core\Tools::normalize($this->data['nombre_empresa']); 
        parent::__construct('config', 'bd_'. $this->code, 2);
        
    }
    public function name(){
        return $this->data['nombre_empresa']; 
    }
    public function data(){
        return $this->data; 
    }
    public function conf_css(){
        $this->table = "config_css"; 
        $this->conf_css = $this->getAll('*',MYSQLI_ASSOC)[0];
        return  $this->conf_css;
    }
    private function conf(){
        return $this->getAll('*',MYSQLI_ASSOC )[0];
    }
    public function getConf(){
        $this->conf = array_merge($this->data(), $this->conf(), $this->conf_css()); 
        return $this->conf;  
    }

    public function festivos(){
        $this->table="festivos"; 
        $festivos = $this->getAll('fecha'); 
        foreach($festivos as $date){

            $date =new DateTime($r);
            $date = date_format($date,"md");
            $data['festivos'][]=$date;	

        }
        return $data['festivos']??false;
    }
}