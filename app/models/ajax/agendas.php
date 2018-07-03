<?php
header('Content-Type: application/json');
$action = $_POST['action']; 
$_POST = $Forms->sanitize($_POST); 

switch($action){
	case "save":
		$chck = $_POST['chck']??0;

		for ($i=0 ; $i <= CONFIG['num_ag'] ; $i++){
			$return  = $Agendas->saveById($_POST['id'][$i] , [
				'mostrar' => $_POST['chck'][$i],
				'nombre' => ($_POST['nombre'][$i])??"agenda".$_POST['id'][$id]
			]);
			if(!$return) break; 
		}
		break;
	case "add":
		$H = new \models\Horarios; 
		$return = ($Agendas->add(CONFIG['num_ag']))
			?$H->initialize($Agendas->getId())
			: false ; 
		break;
	case "del": 
		$return = $Agendas->deleteById($_POST['id']);
		break;
	case "saveName":
		$return = $Agendas->saveById($_POST['id'] , $_POST );
		break; 
}

echo json_encode($return);