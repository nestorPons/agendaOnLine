<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$sql = "SELECT * FROM del_data WHERE idCita = ".$_GET['idCita'];
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result)==0){
	$sql= 'INSERT INTO del_data (idCita,agenda,idUsuario,fecha,obs,UsuarioCogeCita) 
			SELECT idCita,agenda,idUsuario,fecha,obs,UsuarioCogeCita
			FROM data 
			WHERE idCita = '.$_GET['idCita'];
	mysqli_query($conexion, $sql);
}	

$sql = 'INSERT INTO del_cita SELECT * FROM cita WHERE idCita = '.$_GET['idCita'].' AND Servicio= '.$_GET['idSer'].';' ;
$sql .='DELETE FROM cita WHERE idCita = '.$_GET['idCita'].' AND Servicio= '.$_GET['idSer'].';';
if(mysqli_multi_query($conexion, $sql)){
	$sql ='SELECT * FROM cita WHERE idCita = '.$_GET['idCita'].';';
	$result = mysqli_query($conexion, $sql);
	if(mysqli_num_rows($result)==0){	
		$sql = 'DELETE FROM data WHERE idCita='.$_GET['idCita'];
		mysqli_query($conexion, $sql);
	}	
}


echo json_encode($data);