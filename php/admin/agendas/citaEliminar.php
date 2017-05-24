<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

include "consulta.php";//consulta actualizacion para no tener que mandar dos peticiones cueando se elimina

$sql = "SELECT * FROM del_data WHERE IdCita = ".$_GET['idCita'];
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result)==0){
	$sql= 'INSERT INTO del_data (IdCita,Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita) 
			SELECT IdCita,Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita
			FROM data 
			WHERE IdCita = '.$_GET['idCita'];
	mysqli_query($conexion, $sql);
}	

$sql = "";
$ser = $_GET['servicios'];

for($i = 0; $i < count($ser);$i++){
	$sql .= 'INSERT INTO del_cita SELECT * FROM cita WHERE IdCita = '.$_GET['idCita'].' AND Servicio= '.$ser[$i].';' ;
	$sql .='DELETE FROM cita WHERE IdCita = '.$_GET['idCita'].' AND Servicio= '.$ser[$i].';';
}
$result = mysqli_multi_query($conexion, $sql);

$sql = 'SELECT * FROM cita WHERE IdCita ='. $_GET['idCita'];

if(mysqli_query($conexion, $sql)==0){	
	$sql = 'DELETE FROM data WHERE IdCita='.$_GET['idCita'];
	mysqli_query($conexion, $sql);
	$data['success']=true;
}else{$data['success']=false;}

echo json_encode($data);