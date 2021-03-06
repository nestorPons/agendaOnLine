<?php namespace models;

final class Empresa extends \core\BaseClass {
   private $data, $code, $conf_css, $conf, $plan, $dbName;

    function __construct($codeEmpresa){
        parent::__construct('empresas', 'aa_db', 2);
 
//AKI :: implementar metodo para crear una session con los datos 
//y no tener que hacer tantas peticiones 
//ademas debera actualizar cadavez que se cambien los datos INSERT o UPDATE

        $this->code = $codeEmpresa; 
        $this->dbName = PREFIX_DB . $codeEmpresa;
        
        $this->data = $this->getBySQL("replace(`nombre_empresa`,' ','') = '$codeEmpresa' LIMIT 1",  MYSQLI_ASSOC)[0]??false;   
        
        $planes = new \core\BaseClass('planes','aa_db',2); 

        $this->plan = $planes->getById((int)$this->data['plan']); 

        parent::__construct('config', $this->dbName , 2);
        
    }
    public function dbName(string $dbName=null){
        if($dbName!=null) $this->dbName = $dbName; 
        return $this->dbName;
    }
    public function code(string $code=null){
        if($code!=null) $this->code = $code; 
        return $this->code;
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
        $this->table = "config";
        return $this->getAll('*',MYSQLI_ASSOC )[0]??false;
    }
    public function getConf(){
        $this->conf = array_merge($this->data(), $this->conf(), $this->conf_css(), $this->plan); 
        return $this->conf;  
    }

    public function festivos(){
        $this->table="festivos"; 
        $festivos = $this->getAll('fecha'); 
        foreach($festivos as $date){

            $date =new \DateTime($date[0]);
            $date = date_format($date,"md");
            $data['festivos'][]=$date;	

        }
        return $data['festivos']??false;
    }
}