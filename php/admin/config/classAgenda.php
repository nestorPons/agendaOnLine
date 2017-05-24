<?php namespace config;
class agendas {
	
	var $nombres;
	
	function __construct(){
		global $conexion;
		if(empty($conexion)){
			require('../../connect/conexion.php');
			$conexion = conexion(false);
		}
	}
	
	function consulta (){
		global $conexion;
		$sql = "SELECT * FROM agendas";
		$result = mysqli_query($conexion, $sql); 
		
		return  mysqli_fetch_all($result); 
	}
}