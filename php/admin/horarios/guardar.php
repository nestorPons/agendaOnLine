<?php 
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion(true,false,true);
$sql='';
$data_arr = ($_GET['data']);


for($i = 0 ; $i < count($data_arr); $i++){
	$data = $data_arr[$i];	
	$data_ini = date('H:i:s' ,strtotime( $data['ini']));
	$data_fin = date('H:i:s' ,strtotime( $data['fin']));
	if($data['action']=='n'){
		$sql .= 'INSERT INTO horarios (id, agenda, dia, inicio, fin) 
		VALUES ('.$data['id'] . ', '.$data['agenda'] . ', '.$data['dia'] . ', "'.$data_ini . '","'.$data_fin. '");';
	} else {
		$sql .= 'UPDATE horarios
					SET agenda='.$data['agenda'] . ', dia='.$data['dia'] . ',inicio= "'.$data_ini . '",fin="'.$data_fin . '"
					WHERE id=' . $data['id'] . ';';
	}
}

$return['success']=mysqli_multi_query($conexion,$sql);

echo json_encode($return);