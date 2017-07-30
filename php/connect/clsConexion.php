<?php
if (strlen(session_id()) < 1) session_start ();

class Conexion {
	private $server ;
	private $user ;
	private $pass ;
	private $bd ;
	private $result ; 
	private $conexion ; 

	function __construct($server, $user , $pass , $bd) {
		$this->server = $server ;
		$this->user = $user ;
		$this->pass = $pass ;
		$this->bd = $bd ;
		$this->connect() ;
	}

	private function connect(){
		$this->conexion = mysqli_connect($this->server, $this->user, $this->pass , $this->bd) ;
		@mysqli_query("SET NAMES 'utf8'") ;
	}

	public function query($sql){
		$result = mysqli_query( $this->conexion, $sql) or die ( mysqli_error($this->conexion) ) ;
		return $result ;
	}

	public function multi_query ($sql) {
		return mysqli_multi_query($this->conexion, $sql) or die ( mysqli_error($this->conexion) ) ;
	}

	public function row( $sql ){
		return  mysqli_fetch_row($this->query($sql)) ;
	}

	public function assoc( $sql ) {	
		return  mysqli_fetch_assoc($this->query( $sql )) ;
	}

	public function all( $sql , $type = MYSQLI_NUM ) {	
		return mysqli_fetch_all($this->query($sql),$type);
	}

	public function array( $sql ) {	
		return  mysqli_fetch_array($this->query($sql)) ;
	}

	public function id () {
		return mysqli_insert_id($this->conexion) ;
	}

	public function num ($sql) {
		return mysqli_num_rows($this->query($sql)) ;
	}

	public function error () {
		return mysqli_error($this->conexion) ;
	}
	
	function __destruct() {
		$this->conexion->close();
	}

}

$conn = new Conexion('localhost','user','0Z8AHyYDKN0hUYik','bd_' . $_SESSION['bd']);