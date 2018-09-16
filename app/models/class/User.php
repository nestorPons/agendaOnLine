<?php namespace models;

class User extends \core\BaseClass {
	
	private $user, $pass, $config, $data, 
		$authEmail, $color, $lang;
		
	public $nombre, $email, $tel, $id, $dateBaja, $dateReg, $idioma, $admin, $obs, $pin, $token = 'undefined';

	public function __construct( $id ){

		try{

			parent::__construct('usuarios');

			if(filter_var($id, FILTER_VALIDATE_INT)){

				if($id==-1){
					if($this->saveById(-1)) 
						$this->id = $this->conn->id();
					else
						die('No se pudo guardar el usuario');
				} else {
			
					$this->user =  parent::getById($id); 
					
				}
			} else {

				$this->user = (filter_var($id, FILTER_VALIDATE_EMAIL))
					? parent::getOneBy('email', $id)
					: parent::getOneBy('nombre', $id);
				
			}
			//Nuevo usuario

			//Compruebo que exita la conf de usuario si no inicio un registro
			/*
			parent::__construct('usuarios_config');
			if(!parent::getById($id)) parent::saveById(_NEW, ['id'=>$id]);
			*/
			
			if ( $this->user ){

				$this->id = $this->user['id'];
				$this->nombre = $this->user['nombre'];
				$this->email = $this->user['email'];
				$this->pass = $this->user['pass'];
				$this->tel = $this->user['tel'];
				$this->dateBaja = $this->user['dateBaja'];
				$this->dateReg = $this->user['dateReg'];
				$this->admin = $this->user['admin'];
				$this->status = $this->user['status'];
				$this->pin = $this->user['pin'];
				//Configuracion de usuario 
				$this->color = $this->user['color'];
				$this->idioma = $this->user['idioma'];
				$this->authEmail = $this->user['authEmail'];

			} 
		} catch (Exeption $e){
			throw new Exception('No existe el usuatio'); 
		}
		
	 }
	public function get($args){
		return self::getById($this->id, $args);
	 }
	public function set($args){
		return self::saveById((int)$this->id, $args);
	 }
	public function data(array $arg = null){
		if($arg) $this->user = $arg;
		return $this->user;  
	}
	public function save($args = null){
		unset($args['id']);
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
	public function getData(){
		$Data = new \core\BaseClass('data'); 
		// Solicitamos las citas que el campo fecha sean superiores o iguales a la fecha actual 
		$result =  $Data->getBy(['idUsuario','fecha < CURRENT_DATE()'],[$this->id,'TRUE'], '*', MYSQLI_ASSOC, 'ORDER BY fecha, hora ASC' );
		
		// Si el dia es el mismo quitamos del resultado las horas que ya hayan pasado
		foreach($result as $k => $v){
			if($v['fecha']==date('Y-m-d') && $v['hora'] < date('H:i:s')  ) unset($result[$k]);
		}
		
		return $result;
	 }
	public function getCitas($idCita){
		
		$sql = "SELECT C.id, S.descripcion , S.id as idSer 
			FROM cita C 
			JOIN servicios S ON C.servicio = S.id
			WHERE C.idCita = $idCita";  

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
	public function history( \DateTime $ini, \DateTime $end, $totalRecords){
		$ini = $ini->format('Y-m-d H:i:s');
		$end = $end->format('Y-m-d H:i:s');
		$Data = new \core\BaseClass('data');
		$Cita = new \core\BaseClass('cita');
		$Serv = new \core\BaseClass('servicios');

		$data = $Data->getBy('idUsuario',$this->id, '*', MYSQLI_ASSOC, 'LIMIT ' . $totalRecords);
		$arr = [];
		foreach($data as $i => $d){
			$arr[$i] = $d;
			$services = $Cita->getBy('idCita',$d['id'],'servicio');
			foreach($services as $s){
				$arr[$i]['servicios'][] = $Serv->getById($s,'descripcion'); 
			}
		}
		return($arr);
	 }
	public function sendMail($file_mens, $alt_body, $arr_args_mens){
		if($this->authEmail){
			$Mail = new \models\PHPMailer(true);
			
			$Mail->IsHTML(true);
			if($this->isGmail())
				$Mail->AddEmbeddedImage(URL_IMG . 'btn_google_calendar.gif', 'btn', 'btn_google_calendar.gif');
			if($this->isOutlook())
				$Mail->AddEmbeddedImage(URL_IMG . 'outlook-logo-p.jpg', 'btn', 'outlook-logo-p.jpg');
			$Mail->AddEmbeddedImage(URL_LOGO, 'logo', 'logo.jpg');
			$Mail->AddEmbeddedImage(URL_BACKGROUND, 'background-image', 'background.jpg');

			$Mail->addAddress($this->email, $this->nombre);   
			$Mail->url_menssage = URL_EMAILS . $file_mens;
			$Mail->Body    = \core\Tools::get_content($Mail->url_menssage,$this, $arr_args_mens);
			$Mail->AltBody = $alt_body;
			$Mail->Subject =  $alt_body;

			return $Mail->send($this) ;
	
		}else{
			return false;
		}
	 }
	public function authEmail($val = null){
		if($val==null)
			return $this->authEmail; 
		else 
			$this->authEmail = $val; 
	 }	
	public function getId(){
		return $this->id; 
	 }
	public function createUrlEventCalendarGoogle($date, $hour, $time){
		$interval = new \DateInterval('PT'.$time.'M');
		$date= \DateTime::createFromFormat('Y-m-d H:i',$date .' '. $hour);
		$ini = $date->format('Ymd\THis'); 
		$date->add($interval);
		$end = $date->format('Ymd\THis'); 
		$c1 = str_replace(' ', '_',NAME_EMPRESA);
		$c2 = str_replace(' ', '+',NAME_EMPRESA);
		return "https://www.google.com/calendar/event?action=TEMPLATE&text=cita_$c1&dates=$ini/$end&details=tiene+una+cita+en+$c2&location=Castellon&trp=false";
		
		
	 }
	public function isGmail(){
		return strpos($this->email,'gmail')!=false; 
	 }
	public function isOutlook(){
		return strpos($this->email,'hotmail')!=false; 
	 }
	public function pass(string $param = null){
		if($param) {
			$this->pass = password_hash($param, PASSWORD_BCRYPT); 
			$this->set(['pass'=>$this->pass]); 	
		} 
		return $this->pass; 
	 }
	public function comparePass(string $param = ''){
		 return password_verify($param, $this->pass); 
	 }
}