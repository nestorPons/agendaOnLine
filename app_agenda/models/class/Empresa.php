<?php namespace models;

final class Empresa extends \core\BaseClass {
   private $data, $code, $conf_css, $conf, $plan, $dbName;

    function __construct($codeEmpresa){
        parent::__construct('empresas', 'aa_db', 2);

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
        $css = $this->getAll('*',MYSQLI_ASSOC); 
        return  $this->conf_css = isset($css[0]) ? $css[0] : false;
    }
    private function conf(){
        $this->table = "config";
        $css = $this->getAll('*',MYSQLI_ASSOC );
        return isset($css[0])? $css[0] : false;
    }
    public function getConf(){
        $arr1 = $this->data()?:[];
        $arr2 = $this->conf()?:[];
        $arr3 = $this->conf_css()?:[];
        $arr4 = $this->plan?:[];

        $this->conf = array_merge($arr1,$arr2,$arr3,$arr4); 
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