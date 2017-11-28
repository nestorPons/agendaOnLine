<?php 
header('Content-Type: application/json');

$Horarios->multi_query = true ;

if ($_POST['action'] == 'save') {
	
	$data_arr = $_POST['data'];

	for($i = 0 ; $i < count($data_arr); $i++){

		$data = $data_arr[$i];	
		$data['inicio'] = date('H:i:s' ,strtotime( $data['inicio']));
		$data['fin'] = date('H:i:s' ,strtotime( $data['fin']));

		$Horarios->saveById($data['id']??0  , $data ) ;		

	}

} else {
	foreach ($_POST['ids'] as $id){
		$Horarios->deleteById( $id ) ;
	}
}

echo json_encode( $Horarios->multi_query() );