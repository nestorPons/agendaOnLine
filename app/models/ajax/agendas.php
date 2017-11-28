<?php
header('Content-Type: application/json');

	$chck = $_POST['chck']??0;

	$Agendas->multi_query = true ;

	for ($i=0 ; $i < CONFIG['num_ag'] ; $i++){
		$a = $i+1;
		
		$data = array(
			'mostrar' => ($chck==-1)?0:in_array($a,$chck)?1:0,
			'nombre' => ($_POST['nombre'][$i])??"agenda$a"
		);
		$Agendas->saveById($a , $data );
	}

echo json_encode( $Agendas->multi_query() );