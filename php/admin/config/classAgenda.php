<?php namespace config;
class agendas {
	
	private $nombres;
	private $conn ; 
	
	function __construct(){

		$this->conn = new connect\Conexion( 'bd_' . $_SESSION['bd'] );
	
	}
	
	function consulta (){
			
		return  $this->all( "SELECT * FROM agendas" ); 
	
	}
}