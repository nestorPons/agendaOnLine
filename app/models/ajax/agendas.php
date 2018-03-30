<?php
header('Content-Type: application/json');
$action = $_POST['action']; 
$_POST = $Forms->sanitize($_POST); 

switch($action){
	case "save":
		$chck = $_POST['chck']??0;

		$Agendas->multi_query = true ;

		for ($i=0 ; $i < CONFIG['num_ag'] ; $i++){
			
			$a = $_POST['chck'][$i];

			$data = array(
				'mostrar' => ($chck==-1)?0:in_array($a,$chck)?1:0,
				'nombre' => ($_POST['nombre'][$i])??"agenda$a"
			);
			$Agendas->saveById($a , $data );

		}
		$return = $Agendas->multi_query();
		break;
	case "add":
		$return = $Agendas->add(CONFIG['num_ag']);
		break;
	case "del": 
		$return = $Agendas->deleteById($_POST['id']);
		break;
	case "saveName":
		$return = $Agendas->saveById($_POST['id'] , $_POST );
		break; 
}

echo json_encode($return);