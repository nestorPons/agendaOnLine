<?php namespace core ;

class Conexion extends \conf\UserConn {
	private $conexion ; 

	public $result, $error = false, $mQCount, $mQResult;

	function __construct( $db = null, $user = 0 ) {
		
		switch($user){
			case 0:
				$this->user();
				break;
			case 1:
				$this->create();
				break;
			case 2:
				$this->select();
				break;
			case 3:
				$this->createDemo();
				break;
		}
		
		$this->db = $db;

		if (!$this->connect()) 
			 throw new \Exception(\core\Error::E051,51 );
	 }
	private function connect(){
		try{
			if(
				$this->conexion = mysqli_connect($this->server, $this->user, $this->pass, $this->db)
			){
				@mysqli_query("SET NAMES 'utf8'") ;
				@mysqli_query("SET time_zone= Europe/Madrid") ;
				
				return $this->conexion??header("HTTP/1.0 404 Not Found");
			} else {
				throw new \Exception('Error de conexion');
			}

		} catch (\Exception $e) {
			echo $e->getMessage();
			echo ('<br>');
			print_r([$this->server, $this->user, $this->db]);
			exit;
		}
	
	 }
	public function selectDb(string $db){
		return mysqli_select_db ( $this->conexion, $db );
	 }
	public function query($sql){	
		$this->result = mysqli_query( $this->conexion, $sql) or die(mysqli_error($this->conexion));	
		return $this->result ;
	 }

	//Funcion original multi query 
	//La que hay que usar por defecto
	public function multi_query ($sql) {
	
		$return = mysqli_multi_query($this->conexion, $sql) or die ( 'error multiquery =>' . mysqli_error($this->conexion) ) ;
		while(mysqli_more_results($this->conexion) && mysqli_next_result($this->conexion)){
			$result = mysqli_store_result($this->conexion);
			if(is_object($result)){ $result->free(); }
			unset($result);
		 }
		return $return ;
	 }

	//Fake multi query 
	//Se usa para obtener el resultado de todas las querys 
	//Si hay allgun error lo muestra
	public function multiQuery(string $sql){
		$arr = explode(';',$sql);
		array_pop($arr);
		$this->mQCount = count($arr);
		
		for($i = 0; $i < $this->mQCount ; $i++ ){
			if (!empty($arr[$i]))
				$this->mQResult[$i] = $this->query($arr[$i]);				
		}
		return $this->mQResult[$this->mQCount-1];
	 }
	 
	public function scape ($str) {
	
		if(!$this->error){
			
			$replace = ['=',"'",'"','/','#','*',"<",">",":","{","}","?","|","&"];
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
		if($this->error!=false){
			echo $this->error;
		}
		if($this->conexion) $this->conexion->close();
	 }

}