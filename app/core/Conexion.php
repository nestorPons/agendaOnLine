<?php namespace core ;

class Conexion {
	private $bd , $server , $user , $pass ;

	public $result ; 
	public $error = false ;

	private $conexion ; 

	function __construct( $bd = null ) {
		$config = include (URL_CONFIG . 'conn.conf.php')	; 

		if ($config) {
			$this->bd = $bd ?? $config['db'] ;
			$this->server = $config['server'] ;
			$this->user = $config['user'] ;
			$this->pass = $config['pass'] ;
			$this->connect() ;
		} else {

			$this->error = 2 ;
			
		}

	}

	public function connect( ){
		$this->conexion = mysqli_connect($this->server, $this->user, $this->pass , $this->bd) ;	
		@mysqli_query("SET NAMES 'utf8'") ;
	}

	public function query($sql){

		$this->result = mysqli_query( $this->conexion, $sql) or die ( mysqli_error($this->conexion) ) ;
		return $this->result ;
	}

	public function multi_query ($sql) {
		return mysqli_multi_query($this->conexion, $sql) or die ( mysqli_error($this->conexion) ) ;
	}

	public function scape ($str) {
		
		if(!$this->error){
			
			$replace = ['=',"'",'"','/','#','*',"<",">",":","{","}","?"];
        	$str = str_replace($replace, '' , $str);
        	$str = trim($str);        
			return mysqli_real_escape_string($this->conexion, $str) ;

		}else{

			return false ;

		}
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
	public function errno () {
		return mysqli_errno($this->conexion) ;
	}
	
	function __destruct() {
		$this->conexion->close();
	}

}