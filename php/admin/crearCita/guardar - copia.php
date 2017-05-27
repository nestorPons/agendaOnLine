<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$fecha =$_POST['fecha']??mnsExit('Sin fecha');
$hora = $_POST['hora'][0]??mnsExit('Sin hora');
$userId = idUsuario($_POST['cliente'])??mnsExit('Id usuario vacio');
$servi = $_POST['servicios']??mnsExit('No sse han pasado servicios');
$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');
$nota = $_POST['nota']??"";

function mnsExit($mns){
	echo($mns);
	exit();
}
function idUsuario($userName){
	global $conexion;
	$sql = "SELECT usuarios.Id FROM usuarios WHERE usuarios.Nombre LIKE '$userName'";
	$result = mysqli_query($conexion,$sql);
	$row= mysqli_fetch_row($result);
	return $row[0];
}
function consultaDatos($idCita){
	global $fecha;
	$con = conexion();

	$sql = 'SELECT C.Id, A.Codigo, D.Agenda, D.IdCita, D.IdUsuario, U.Nombre, D.Obs, C.Hora , D.Fecha ,A.Tiempo, A.Id AS IdCodigo
	FROM cita C JOIN data D ON C.IdCita = D.IdCita
	INNER JOIN usuarios U ON D.IdUsuario = U.Id
	LEFT JOIN articulos A ON C.Servicio = A.Id
	WHERE D.IdCita ='.$idCita.'
	ORDER BY D.Fecha, D.Agenda, C.Hora;';

	$result = mysqli_query($con,$sql);
	$data = mysqli_fetch_all($result,MYSQLI_ASSOC);

	return $data;
}

$h = $hora;

for ($i = 0; $i < count($servi); $i++) {
	$ocupado = 0 ;

	$servicio = $servi[$i];
	$sql= "SELECT A.Tiempo, A.Id FROM articulos A WHERE Id  = ". $servicio;
	$row= mysqli_fetch_array(mysqli_query($conexion,$sql));
	$unidades_t = ceil(($row['Tiempo'] / 15));

	for ($a = 1; $a <= ($unidades_t); $a++) {
		$sql="SELECT D.IdCita
		FROM cita C
		JOIN data D ON C.IdCita = D.IdCita
		WHERE D.Fecha = '$fecha' AND C.Hora =$h AND D.Agenda = $agenda;" ;

		$result = mysqli_query($conexion,$sql);
		if(mysqli_num_rows($result)!=0){
			$ocupado++;
		}
		$h++;
	}
}
if ($ocupado<2){
	$data['ocupado']=false;
	$sql= "INSERT INTO data (Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita) VALUE ($agenda,$userId,'$fecha','$nota',".$_SESSION['id_usuario'].")";
	if (mysqli_query($conexion,$sql)){
		$idServicio = mysqli_insert_id($conexion);
		for ($i = 0; $i < count($servi); $i++) {

			$sql= "SELECT A.Tiempo, A.Id FROM articulos A WHERE Id  = ". $servi[$i];
			$result_t = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			$ser= mysqli_fetch_array($result_t);
			$unidades_t = ceil(($ser['Tiempo'] / 15));

			$sql="";
			for ($a = 1; $a <= ($unidades_t); $a++) {
				
				$sql .= "INSERT INTO cita (IdCita, Hora, Servicio) VALUE ($idServicio,$hora,".$ser['Id'].");";
				$hora++;

			}
			mysqli_multi_query($conexion,$sql);
			$data['datos'] = consultaDatos($idServicio);
		}
	}else{$data['err']=$sql;}
}else{
	$data['ocupado']=true;
}

//if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");
//registrarEvento(1, $idServicio,$_SESSION['id_usuario'],$agenda);
echo json_encode($data);