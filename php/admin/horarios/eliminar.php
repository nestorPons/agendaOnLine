<?php 
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion(true,false,true);
$sql = "";

foreach ($_GET['id'] as $id){
	$sql .= 'DELETE FROM horarios WHERE id = '. $id . ';';
}

$return['success']=mysqli_multi_query($conexion,$sql);

echo json_encode($return);