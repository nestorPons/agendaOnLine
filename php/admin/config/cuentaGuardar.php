<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$sendAdmin = (!empty($_GET['sendMailAdmin']))?1:0;
$sendUser = (!empty($_GET['sendMailUser']))?1:0;
$festivos = (!empty($_GET['festivosON']))?1:0;
$sql = "UPDATE config SET sendMailAdmin = $sendAdmin,	sendMailUser = $sendUser, festivosON  = $festivos WHERE idEmpresa = ". CONFIG['idEmpresa'].";";
$jsondata['sql']=$sql;

$jsondata['success'] =(mysqli_query($conexion,$sql))?true:false;
	 
echo json_encode($jsondata);