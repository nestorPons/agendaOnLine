<?php namespace models;

class User extends \core\BaseClass {
	
	private $user, $pass, $table = 'usuarios' ;
	public $nombre, $email, $tel, $id, $dateBaja, $dateReg, $idioma, $admin, $obs;
	
	public function __construct( $id ){
		
		parent::__construct($this->table);

		$this->user = parent::getById($id);
		
		$this->id = $id ;
		$this->nombre = $this->user['nombre'];
		$this->email = $this->user['email'];
		$this->pass = $this->user['pass'];
		$this->tel = $this->user['tel'];
		$this->dateBaja = $this->user['dateBaja'];
		$this->dateReg = $this->user['dateReg'];
		$this->idioma = $this->user['idioma'];
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
       return $this->pass === $pass ;
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
	public function getHistory(){
		$sql = 'SELECT C.id, D.id as idCita, D.fecha, D.hora , S.descripcion , S.id as idSer 
				FROM cita C JOIN data D ON C.idCita = D.id 
				LEFT JOIN servicios S ON C.servicio = S.id 
				WHERE D.idUsuario = '. $this->id .' AND D.fecha >= CURRENT_DATE() 	
				ORDER BY D.fecha, D.hora ';

		return  $this->conn->all($sql , MYSQLI_ASSOC ) ;
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
}