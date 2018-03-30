<?php 
header('Content-Type: application/json');

$Horarios->multi_query = true ;

if ($_POST['action'] == 'save') {
		$r = $Horarios->save($_POST['data'] ) ;		
} else {
	foreach ($_POST['ids'] as $id){
		$Horarios->deleteById( $id ) ;
	}
}
echo json_encode(  $r );