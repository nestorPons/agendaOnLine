<?php namespace models;

final class Login extends \core\BaseClass {
	private $num, $selector, $validator, $pass, $Logs ,$token, $Token;
	public $email, $id, $dateBaja, $admin, $user, $pin;

	public function __construct(){

        if(isset($_COOKIE['auth'])){
            $this->Token = new \core\BaseClass('auth_tokens'); 
            $this->token  = $_COOKIE['auth']; 
            $this->decodeToken($this->token); 
            $this->pin = $this->Token->getOneBy('selector', $this->selector, 'pin');
        } 
		parent::__construct('usuarios');	
        $this->Logs = new \models\Logs;
    }
    public function id(int $id = null){
        if($id) $this->id = $id; 
        return $this->id; 
    }
    public function pin(int $arg = null){
        if($arg) {
            $this->pin = $arg;
            $this->Token->saveBy(['selector'=>$this->selector],['pin'=>$arg] ); 
        } 
        return $this->pin; 
    }
    public function findUserById(int $id){
        if ($this->user = parent::getById($id))
            $this->loadData();
        return $this->user;
     }
    public function findUserBy($column, $value){
        if ($this->user = parent::getOneBy($column, $value))
            $this->loadData();
        
        return !is_null($this->user) ;
     }
    public function user(User $User){   
        $this->user = $User;
        $this->id = $User->id;
        $this->email = $User->email;
        $this->admin = $User->admin;
                
     }
    private function loadData(){
            $this->id = $this->user['id'] ;
            $this->email = $this->user['email'];
            $this->pass = $this->user['pass'];
            $this->dateBaja = $this->user['dateBaja'];
            $this->admin = $this->user['admin'];
            $this->status = $this->user['status'];
            $this->attempts = $this->user['attempts'];
     }
    public function get($args){
		return self::getById($this->id, $args);
	 }
	public function set($args){

		return self::saveById($this->id, $args);
	 }
    public function validatePass( $pass ){
        return password_verify($pass, $this->pass);
     }
    public function validateEmail( string $email ){
		$email = trim( $email ) ;

		if (strpos($email , '@' ) && strpos($email , '.') )  {
			$mail_users = parent::getOneBy( 'email' , $email );
			$return = !empty($mail_users);
			
		} else {

			$return = false ;
		}

		return $return ;
    	}
    public function attempts(int $args = null){
        if (!$this->user)
            die('no se ha encotrado el usuario');
               
		if (is_null($args)){
			return $this->attempts;
		}else if($args > 0){
			$this->attempts += $args;
		}else{
            $this->attempts = 0;
		}

		return $this->set(['attempts'=>$this->attempts]);	
		
     }
	public function status(int $arg = null) {
		return (empty($arg))
			? $this->get('status')
			: $this->set(array('status'=>$arg));
	 }
    public function statusReset(){
        $this->attempts(0);
        
        $Mail = new Mail(new User($this->id));
        $Mail->url_menssage = URL_EMAILS . 'mailActive.php';
        $Mail->send();
        $this->logout();
     }
    public function codeToken(){
      
        $this->num = rand(1,4);
        $this->selector = $this->generateRandomString($this->num);
        $this->validator = $this->generateRandomString(rand(20,30));
        $this->num *= 2;   
        return $this->id . '.' . $this->validator.$this->selector.$this->num;
     }
    public function decodeToken($token){

        $this->num = substr($token, -1);
        $this->selector = substr ($token, -$this->num-1, -1 );
        $arr = explode('.', substr($token, 0, -$this->num-1));
        $this->id = $arr[0]; 
        $this->validator = $arr[1];
        return array($this->num,$this->selector,$this->validator);
        
     }
    private function generateRandomString(int $length = 5) { 
        return bin2hex(random_bytes($length)); 
     } 
     /**
      * Comprueba un token con el almacenado en la base de datos 
      *
      * @param string $tokenByPost el toquen auth cookie => auth
      * @return devuelve el id usuario o falso
      */
    public function authByPin(){

        $token = $this->codeToken();
        setcookie("auth", $token , time()+(60*60*24*60),'/');
        $auth = new \core\BaseClass('auth_tokens');

        if ($auth->saveById(-1,[
                'selector'=> $this->selector,
                'validator'=> $this->validator, 
                'idUser' => $this->id, 
                'pin' => $this->pin??0
            ])){
 
                return $this->codeToken();
            } else return false;

     }

    public function authToken(string $tokenByPost){
        $Auth = new \core\BaseClass('auth_tokens');
        $arr = $this->decodeToken($tokenByPost);
        $auth = $Auth->getOneBy('selector',$this->selector );
        $this->findUserById((int)$auth['idUser']);
        $this->pin = $auth['pin']; 

        return ($auth['validator'] === $this->validator)?$this->id:false;
     }
    public function createSession(bool $remember = false){
        global $Security;

        $Security->loadSession(
            $this->id,
            $_REQUEST['empresa'],
            $this->admin
	    );

        $this->attempts(0);
       
        if ($remember) $this->authByPin();
        
        $this->Logs->set($this->id, 'login'); 

        return ($this->admin>0)?'admin':'users' ;
     }
    public function logout(bool $deleteCookies = false) {

        if($deleteCookies)
            foreach($_COOKIE as $key => $val) setcookie($key, '', time() - 3600, '/');    
         

        // Borra todas las variables de sesión  
        //setcookie('auth','',time()-100);
        setcookie('token','',time()-100);


        $_COOKIE = array();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
             );
         }

        if(isset($_SESSION['id_usuario']))
            $this->Logs->set($_SESSION['id_usuario'], 'logout');
            
        $url = $_SERVER["REQUEST_URI"]; 
        // Finalmente, destruye la sesión 
        session_destroy(); 


        if (!empty(\core\Error::getLast())) $err = '?err=' . \core\Error::getLast();
        return true;

     }
    public function session_start(){
        // Se crea una nueva session
        session_start([
            'cookie_lifetime' => 86400,
        ]);

        return session_id()??false;
     }
    public static function example(){
        $demo = PREFIX_DB . 'demo'; 
        $connDemo = new \core\Conexion(null,3);
        
        $connDemo->multi_query("
            DROP DATABASE IF EXISTS `$demo`;
            CREATE DATABASE `$demo`;
            USE `$demo`;
         ");
        $file  = file_get_contents(APP_FOLDER . 'db/db_template.sql');
        $connDemo->multi_query($file);      
        
        $file  = file_get_contents(APP_FOLDER . 'db/demo.sql');
        $connDemo->multi_query($file);
        unset($connDemo);
     }
    public static function err(string $err, int $num = 0, string $action = 'login'){
           /**
         * Crea nuna descripcion del error de autentificacion
         * 
         * @param string $err mensaje de error
         * @param int $num un codigo de error 
         * @param string $action accion a realiar si se obtiene un error 
         * @return void array con parametros de error
         */
        return array(
            'error' => $err , 
            'num' => $num , 
            'action' => $action
        );
     }
}