<?php namespace models;

class Create{
    public $nameCompany ,$db;
    private $empresas, $pass, $cConn, $post, $id, $exceptionsPost = ['web'];

    public function __construct($post){
        $this->empresas = new \core\BaseClass('empresas','aa_db');
        $this->connect();
        $this->post = $post;
        $this->nameCompany = $this->defineNameCompany();
        $this->db = PREFIX_DB . $this->nameCompany ;
        $this->pass = $this->post['pass'];
        $this->name = $this->post['nombre_usuario'];
        $this->email = $this->post['email'];
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

        $empresa = $this->empresas->getBy('nombre_empresa', $this->post['nombre_empresa'] );
        if (!empty($empresa)) throw new \Exception(\core\Error::E011, 11);
        
        return true;
        
     }
    public function defineNameCompany(){
        $nameCompany = \core\Tools::normalize($this->post['nombre_empresa']);
        return $nameCompany;

     }
    public function saveCompany(){
       
        unset($this->post['pass']);

        if (!$this->empresas->saveById(-1,$this->post))
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
        $pass = password_hash($this->pass,PASSWORD_DEFAULT); 

        $this->connect($this->db);
        $sql = "INSERT INTO usuarios (id, nombre, email, pass, admin, tel) 
        VALUES (1, '{$this->post['nombre_usuario']}' , '{$this->post['email']}','$pass',2, '{$this->post['tel']}');";
        $sql .= "INSERT INTO config (`idEmpresa`) VALUES ({$this->id});";
        $sql .= "INSERT INTO config_css () VALUES ();";
        $sql .= "INSERT INTO agendas (`nombre`) VALUES ('Principal');";
        $sql .= "INSERT INTO familias (id, `nombre`) VALUES (0, 'Familia');";
        $sql .= "INSERT INTO servicios (`codigo`, `descripcion`, `tiempo`, `idFamilia`) 
                    VALUES ('COD001', 'Servicio de prueba', 10, 1);";
        $sql .= "INSERT INTO festivos (`nombre`, `fecha`) VALUES ('Año nuevo', '2018-01-01'),('Reyes', '2018-01-06'),('Navidad', '2018-12-25'),('Noche vieja', '2018-12-31');";
        $sql .= "INSERT INTO horarios (`agenda`, `dia_inicio`, `dia_fin`, `hora_inicio`, `hora_fin`)
            VALUES (1, 0 , 4, '9:00:00','20:00:00'), (1, 5, 5, '9:00:00','14:00:00');";
        
     
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
    public function sendMail(){
        $User = new User(1);

        $Mail = new PHPMailer(true);

        



        $Mail->Subject = "Activar nueva cuenta";
        $Mail->addAddress($User->email, $User->nombre);   
        $Mail->url_menssage = URL_SOURCES . 'mailactivate.php';
        $Mail->Body    = \core\Tools::get_content($Mail->url_menssage, $User->getToken());
        $Mail->AltBody = 'Activar usuario: ' .  $User->token;
        $Mail->Subject =  "Activar cuenta";

        return $Mail->send(); 
    }

 }