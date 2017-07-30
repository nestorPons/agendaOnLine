<?php namespace horarios;

function horarios( $return_row = false ){
	global $conn;
	if(empty($conn)) require('../../connect/clsConexion.php');

	$arrHorarios = $conn->all("SELECT * FROM horarios ORDER BY dia",MYSQLI_ASSOC);
	if ( $return_row ){
		return $arrHorarios;
	}else{
		foreach ($arrHorarios as $key => $value){
			$horarios[$value['dia']] = ['inicio' => $value['inicio'] , 'fin' => $value['fin'] ];
		}

		for ($d = 0 ; $d <= 6 ;$d++ ){
			if (!empty($horarios[$d])){	
			for($h = strtotime($horarios[$d]['inicio']); $h <=  strtotime($horarios[$d]['fin']) ; $h = strtotime("+15 minutes", $h)){	
					$horas_array[$d][] = date('H:i', $h);
				} 
				
			}else{
				$horas_array[$d][] = null;
			}
		}			
	}

	return $horas_array;

}