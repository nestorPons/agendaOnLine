<?php
header('Content-Type: application/json');
include "../../connect/conn.controller.php";

$fecha =$_POST['fecha']??mnsExit('Sin fecha');
$hora = date('H:i',$_POST['hora'][0])??mnsExit('Sin hora');
$userId = idUsuario($_POST['cliente'])??mnsExit('Id usuario vacio');
$servicios = $_POST['servicios']??mnsExit('No se han pasado servicios');
$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');
$nota = $_POST['nota']??"";

$data['success']=true;

function mnsExit($mns){
	echo($mns);
	exit();
}
function idUsuario($userName){
	global $conn;
	$sql = "SELECT usuarios.Id FROM usuarios WHERE usuarios.nombre LIKE '$userName' LIMIT 1";
	$row = $conn->row($sql);
	return $row[0];
}
$result = $conn->row("SELECT * FROM data WHERE fecha = '$fecha' AND hora =  '$hora' LIMIT 1 "  ) ;
if ($result <= 1 ){
	$data['ocupado']=false;
	$sql= "INSERT INTO data (agenda,idUsuario,fecha,hora,obs,UsuarioCogeCita) VALUE ($agenda,$userId,'$fecha', '$hora' ,'$nota',".$_SESSION['id_usuario'].")";
	if ($conn->query($sql)){
		$id_servicio = $conn->id();
		$data['idCita'] = $id_servicio ;
		$sql = '';
		foreach ($servicios as $servicio ) {
			$sql .= 'INSERT INTO cita (idCita, Servicio) VALUE ('.$id_servicio.','. $servicio.') ; ';
		}
		$conn->multi_query($sql) ;
	}
} else {
	$data['ocupado']=true;
	$data['mns']['tile'] = " hora ocupada " ;
	$data['mns']['body'] = " No se pueden reservar dos citas en la misma hora " ;
}
//if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");
//registrarEvento(1, $idServicio,$_SESSION['id_usuario'],$agenda);
echo json_encode($data);