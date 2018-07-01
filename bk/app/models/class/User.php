<?php namespace models;

class User extends \core\BaseClass {
	
	private $user, $pass ;
	public $nombre, $email, $tel, $id, $dateBaja, $dateReg, $idioma, $admin, $obs, $pin, $token = 'undefined';
	
	public function __construct( $id , $email = false){
		
		parent::__construct('usuarios');

		$this->user = ($id)
			? parent::getById($id)
		 	: $this->user = parent::getOneBy('email', $email);

		if ( $this->user ){
			$this->id = $this->user['id'];
			$this->nombre = $this->user['nombre'];
			$this->email = $this->user['email'];
			$this->pass = $this->user['pass'];
			$this->tel = $this->user['tel'];
			$this->dateBaja = $this->user['dateBaja'];
			$this->dateReg = $this->user['dateReg'];
			$this->idioma = $this->user['idioma'];
			$this->admin = $this->user['admin'];
			$this->status = $this->user['status'];
			$this->pin = $this->user['pin'];
		} 
	 }
	public function get($args){
		return self::getById($this->id, $args);
	 }
	public function set($args){
		return self::saveById((int)$this->id, $args);
	 }
	public function password($pass){
		if (!empty($pass)) {
			$pass = password_hash($pass,PASSWORD_BCRYPT);
			$this->set(['status'=>0]); 
			return $this->set(['pass'=>$pass]);
		} else {
			return $this->get('pass');
		}
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
	public function status(int $arg = null) {
		return (empty($arg))
			? $this->get('status')
			: $this->set(array('status'=>$arg));
	 }
	public function getToken(){
		$this->removeToken();
		if ($this->token == 'undefined'){
			$cadena = $this->id.$this->nombre.rand(1,9999999).date('Y-m-d');
			$this->token = sha1($cadena) . str_pad($this->id, 4, "0", STR_PAD_LEFT); 
			
			$Token = new \core\BaseClass('tblreseteopass');
			if( !$Token->saveById(_NEW, [
				'id_user'=> $this->id , 
				'token' => $this->token , 
				'date'	=> \core\Tools::current_date()
			]));
		}

		return $this->token;
     }
	public function checkToken($token){
		$Token = new \core\BaseClass('tblreseteopass'); 
		$tbl = $Token->getOneBy('id_user', $this->id);

		$actualDate = new \DateTime();
		$saveDate = new \DateTime($tbl['date']);
		$saveDate->modify('+30 minute');
		$interval = $actualDate->diff($saveDate);

		// Tiempo limite para activar cuenta
		if(15 < (int)$interval->format("hi")) return \core\Error::set('E061');
		if($tbl['token'] != $token) return \core\Error::set('E062');
		return true;
	 }
	private function removeToken(){
		$Token = new \core\BaseClass('tblreseteopass'); 
		return $Token->deleteBy('id_user', $this->id);
	 }
	public function statusActive($get){
		if (!$this->checkToken($get['args'])) return false;
		return $this->set(['status'=> 0]);
	 }
	public function isAdmin(){
		 return $this->admin==1;
	 }
	public function isUser(){
		 return $this->admin==0;
	 }
 }