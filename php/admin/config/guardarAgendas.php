<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$jsondata['success'] = true;
$agendas=(!empty($_GET['agendas']))?$_GET['agendas']:0;
for ($i=1;$i<=9;$i++){
	$valor =(in_array($i, $agendas))?1:0;
	$sql="UPDATE config SET agenda$i=$valor";
	$jsondata['sql'][$i]=$sql;
	if(!mysqli_query($conexion,$sql)){
		$jsondata['success'] = false;
		echo json_encode($jsondata);
		exit;
	}
}
$jsondata['agendas'] = $agendas;
echo json_encode($jsondata);
?>