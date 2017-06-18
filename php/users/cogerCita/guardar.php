<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$fecha =$_GET['fecha']??false;
$hora = (int)$_GET['hora'][0]??false;
$userId = $_GET['usuario']??false;
$servi = $_GET['servicios']??false;
$agenda =  $_GET['agenda'][0]??false;
$nota = $_GET['nota']??false;
$js['success']=true;
//comprobacion
$h = $hora;
$js['hora']= array();

for ($i = 0; $i < count($servi); $i++) {
	$servicio = $servi[$i];
	$sql= "SELECT A.Tiempo, A.Id FROM articulos A WHERE Id  = ". $servicio;
	$row= mysqli_fetch_array(mysqli_query($conexion,$sql));
	$unidades_t = ceil(($row['Tiempo'] / 15));
	for ($a = 1; $a <= ($unidades_t); $a++) {
		$sql="SELECT D.IdCita FROM cita C JOIN data D ON C.IdCita = D.IdCita WHERE D.Fecha = '$fecha' AND C.Hora =$h;" ;
		if( mysqli_num_rows(mysqli_query($conexion,$sql))!=0){ 
			$js['success']=false;
			break;
		}
		$h++;
	}
}
if ($js['success']){
	$sql= "INSERT INTO data (Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita) VALUE ($agenda,$userId,'$fecha','$nota',".$_SESSION['id_usuario'].")";
	if (mysqli_query($conexion,$sql)){
		$idServicio = mysqli_insert_id($conexion);
		$js['data']['id']= $idServicio;
		for ($i = 0; $i < count($servi); $i++) {
			$servicio = $servi[$i];
			$sql= "SELECT A.Tiempo, A.Id FROM articulos A WHERE Id  = ". $servicio;
			$result_t = mysqli_query($conexion,$sql);
			$row= mysqli_fetch_array($result_t);
			$unidades_t = ceil(($row['Tiempo'] / 15));
			$ser = $row['Id'];
			for ($a = 1; $a <= ($unidades_t); $a++) {
				array_push($js['hora'],$hora);
				$sql = "INSERT INTO cita (IdCita, Hora, Servicio) VALUE ($idServicio,$hora,$ser)";
				if(!mysqli_query($conexion,$sql)){
						$js['success']=false;
						break;
				}
				$js['data']['idCita'][$a] = mysqli_insert_id($conexion);
				$hora++;
			}
		}
	}else{$js['success']=false;}
}
//Registrar coger cita 

//if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");	
//registrarEvento(1, $idServicio,$_SESSION['id_usuario'],$agenda);	

echo json_encode($js);
