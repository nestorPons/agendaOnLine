<?php namespace models;

class Create{
    public $nameCompany ,$db;
    private $empresas, $pass, $cConn, $post, $id;
    private $exceptionsPost = ['web'];

    public function __construct($post){
        $this->empresas = new \core\BaseClass('empresas','aa_db');
        $this->connect();
        $this->post = $post;
        $this->nameCompany = $this->defineNameCompany();
        $this->db = 'bd_' . $this->nameCompany ;
     }
    public function getNameCompany(){
        return $this->nameCompany;
    }
    private function connect ($db = false){
        $this->cConn = new \core\Conexion( $db , 1);
        return $this->cConn;
     }
    public function validateForm(){
        foreach($this->post as $key => $value){
            if (empty($value) && !in_array($key,$this->exceptionsPost))
                throw new \Exception(\core\Error::E012, 12);
         }
        return true;
     }
    public function ifCompanyExist(){

        $empresa = $this->empresas->getBy('nombre_empresa', $this->nameCompany );
        if (!empty($empresa)) throw new \Exception(\core\Error::E011, 11);
        
        return true;
        
     }
    public function defineNameCompany(){
        $nameCompany = \core\Tools::normalize($this->post['nombre_empresa']);
        return $nameCompany;

     }
    public function saveCompany(){
        $this->pass = $this->post['pass'];
        unset($this->post['pass']);

        if (!$this->empresas->saveById(0,$this->post))
            throw new \Exception(\core\Error::E003, 3);
        $this->id = $this->empresas->getId();

        return true;
     }
    public function saveDb(){

         $sql = "CREATE DATABASE " . $this->db . " COLLATE utf8_spanish_ci";

         if(!$this->cConn->query($sql))
            throw new \Exception(\core\Error::E013, 13);
         return true;
     }
    public function createTables(){
        $this->cConn->selectDb( $this->db);
        $fileSQL = file_get_contents(URL_SQL . 'db_template.sql');
        if(!$this->cConn->multi_query($fileSQL))
            throw new \Exception(\core\Error::E015, 15);
        return true;
     }
    public function initializeCompany(){
        $this->connect($this->db);
        $sql = "INSERT INTO usuarios (nombre, email, pass, admin, tel) 
        VALUES ( '{$this->post['nombre_usuario']}' , '{$this->post['email']}','".password_hash($this->pass,PASSWORD_DEFAULT)."',2, '{$this->post['tel']}');";
        $sql .= "INSERT INTO config (idEmpresa) VALUES ({$this->id});";
        $sql .= "INSERT INTO config_css () VALUES ();";
        $sql .= "INSERT INTO agendas (nombre) VALUES ('Principal');";
        $sql .= "INSERT INTO familias (nombre) VALUES ('Familia 1');";
        $sql .= "INSERT INTO servicios (codigo, descripcion, tiempo, idFamilia) VALUES ('COD001', 'Servicio de prueba', 10, 1);";
        for ($i = 0; $i<=6; $i++){
            $sql .= "INSERT INTO horarios (agenda, dia, inicio, fin) VALUES (1,$i,'9:00','20:00');";
        }
        
        if(!$this->cConn->multiQuery($sql))
            throw new \Exception(\core\Error::E016, 16);
        
        return true;
     }
    public function createFolder(){
        try {
            $source = URL_EMPRESAS . 'template';
            
            mkdir( URL_EMPRESAS . $this->nameCompany, 0777);
            return \core\Tools::full_copy( $source, URL_EMPRESAS . $this->nameCompany .'/' );
        } catch (\Exception $e){
            throw new \Exception(\core\Error::E017, 17);     
        }
     }
 }