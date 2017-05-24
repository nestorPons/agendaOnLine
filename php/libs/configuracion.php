<?php
header('Content-Type: application/json');
include "conexion.php";
$conexion = conexion();

$sql = "SELECT * FROM config";
$row = mysqli_fetch_array(mysqli_query($conexion,$sql));
$js['dir'] = !empty($row['dir'])?$row['dir']:"";
$js['gerente'] = !empty($row['gerente'])?$row['gerente']:"";
$js['nombre'] = !empty($row['nombre'])?$row['nombre']:"";
$js['email'] = !empty($row['email'])?$row['email']:"";
$js['tel'] = !empty($row['tel'])?$row['tel']:"";
$js['sendMailAdmin'] = !empty($row['sendMailAdmin'])?true:false;
$js['sendMailUser'] = !empty($row['sendMailUser'])?true:false;
$js['festivosON'] = !empty($row['festivosON'])?true:false;
$array =explode('/', $_SERVER['REQUEST_URI'] );
$url= "/". $array[1]."/".$array[2] ."/admin/agendas/agendas.php";
$js['url'] = $row['numAgendas']==1?$url."?a=1":$url."?a=0";
$js['numAg']  =$row['numAgendas'];

echo json_encode($js);
?>