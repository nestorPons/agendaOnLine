<?php namespace Horarios;

function horarios( $return_row = false ){
		global $conexion;
		if(empty($conexion)){
			require('../../connect/conexion.php');
			$conexion = conexion(false);
		}

	$sql = "SELECT * FROM horarios ORDER BY dia";
	$row = mysqli_fetch_all(mysqli_query($conexion,$sql),MYSQLI_ASSOC);

	if ( $return_row ){
		return $row;
	}else{
		foreach ($row as $key => $value){
			$inicio_horarios[$value['dia']][] = $value['inicio'];
			$fin_horarios[$value['dia']][] = $value['fin'];
		}

		for ($d = 0 ; $d <= 6 ;$d++ ){
			if (!empty($inicio_horarios[$d])){
				for ($i = 0 ; $i < count($inicio_horarios[$d]); $i++){
					for($h =  strtotime($inicio_horarios[$d][$i]); $h <=  strtotime($fin_horarios[$d][$i]) ; $h += strtotime("+15 minutes", strtotime($h))){	
						$horas_array[$d][] = date('H:i', $h);
					} 
				}
			}
		}			
	}
	
	return $horas_array;
}