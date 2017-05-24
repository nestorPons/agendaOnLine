<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$sql = "SELECT * FROM del_data WHERE IdCita = ".$_GET['idCita'];
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result)==0){
	$sql= 'INSERT INTO del_data (IdCita,Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita) 
			SELECT IdCita,Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita
			FROM data 
			WHERE IdCita = '.$_GET['idCita'];
	mysqli_query($conexion, $sql);
}	

$sql = 'INSERT INTO del_cita SELECT * FROM cita WHERE IdCita = '.$_GET['idCita'].' AND Servicio= '.$_GET['idSer'].';' ;
$sql .='DELETE FROM cita WHERE IdCita = '.$_GET['idCita'].' AND Servicio= '.$_GET['idSer'].';';
if(mysqli_multi_query($conexion, $sql)){
	$sql ='SELECT * FROM cita WHERE IdCita = '.$_GET['idCita'].';';
	$result = mysqli_query($conexion, $sql);
	if(mysqli_num_rows($result)==0){	
		$sql = 'DELETE FROM data WHERE IdCita='.$_GET['idCita'];
		mysqli_query($conexion, $sql);
	}	
}


echo json_encode($data);