<?php namespace models;

class Login extends \core\BaseClass {
	private $num, $selector, $validator, $user, $pass, $table = 'usuarios';
	public $email, $id, $dateBaja, $admin;
	
	public function __construct(  ){
		parent::__construct($this->table);		
	}
    public function findUserById(int $id){
        $this->user = parent::getById($id);
        $this->loadData();
        
    }
    public function findUserBy($column, $value){
        if ($id = parent::getOneBy($column, $value,'id')){
            $this->user = parent::getById($id);
            $this->loadData();
        }

        return !is_null($id) ;
    }
    private function loadData(){
            $this->id = $this->user['id'] ;
            $this->email = $this->user['email'];
            $this->pass = $this->user['pass'];
            $this->dateBaja = $this->user['dateBaja'];
            $this->admin = $this->user['admin'];
            $this->status = $this->user['status'];
    }
    public function get($args){
		return self::getById($this->id, $args);
	}
	public function set($args){
		return self::saveByID($this->id, $args);
	}
    public function validatePass( $pass ){
        return password_verify ($pass, $this->pass);
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
		$attempts = self::get('attempts');
		if (is_null($args)){
			return $attempts;
		}else if($args > 0){
			$attempts += $args;
			$data = array('attempts'=>$attempts);
		}else{
			$data = array('attempts'=>0);
		}

		$this->set($data);	
		return $attempts;
	}
	public function status(int $arg = null) {
		return (empty($arg))
			? $this->get('status')
			: $this->set(array('status'=>$arg));
	}
    public function codeToken(){
      
        $this->num = rand(1,4);
        $this->selector = $this->generateRandomString($this->num);
        $this->validator = $this->generateRandomString(rand(20,30));
        $this->num *= 2;

        return $this->validator.$this->selector.$this->num;
    }
    public function decodeToken($token){

        $this->num = substr($token, -1);
        $this->selector = substr ($token, -$this->num-1, -1 );
        $this->validator = substr($token, 0, -$this->num-1);

        return array($this->num,$this->selector,$this->validator);
        
    }
    private function generateRandomString(int $length = 10) { 
        return bin2hex(random_bytes($length)); 
    } 
    public function authByCookie(){

        $token = $this->codeToken();
        setcookie("auth", $token , time()+(60*60*24*60),'/');

        $auth = new \core\BaseClass('auth_tokens');

        return $auth->saveById(0,[
                'selector'=> $this->selector,
                'validator'=>$this->validator, 
                'idUser' => $this->id
            ]);
    }
    public function authToken($tokenByPost){
        $Auth = new \core\BaseClass('auth_tokens');
        $this->decodeToken($tokenByPost);
        $auth = $Auth->getOneBy('selector',$this->selector );
        $this->findUserById((int)$auth['idUser']);

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
        if ($remember) $this->authByCookie();

        return ($this->admin!=1)?'admin':'users' ;
    }
}