<?php
header('Content-Type: application/json');
include "../../connect/clsConfig.php";

$fecha =$_POST['fecha']??mnsExit('Sin fecha');
$hora = $_POST['hora'][0]??mnsExit('Sin hora');
$userId = idUsuario($_POST['cliente'])??mnsExit('Id usuario vacio');
$servi = $_POST['servicios']??mnsExit('No sse han pasado servicios');
$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');
$nota = $_POST['nota']??"";

$data['success']=true;

function mnsExit($mns){
	echo($mns);
	exit();
}
function idUsuario($userName){
	global $conn;
	$sql = "SELECT usuarios.Id FROM usuarios WHERE usuarios.Nombre LIKE '$userName' LIMIT 1";
	$row = $conn->row($sql);
	return $row[0];
}
$h = $hora;

for ($i = 0; $i < count($servi); $i++) {
	$ocupado = 0 ;

	$servicio = $servi[$i];
	$sql = "SELECT A.Tiempo, A.Id FROM articulos A WHERE Id  = $servicio LIMIT 1";
	$row = $conn->array($sql);
	$unidades_t = ceil(($row['Tiempo'] / 15));

	for ($a = 1; $a <= ($unidades_t); $a++) {
		$sql="SELECT D.IdCita
		FROM cita C
		JOIN data D ON C.IdCita = D.IdCita
		WHERE D.Fecha = '$fecha' AND C.Hora =$h AND D.Agenda = $agenda LIMIT 1;" ;

		if( $conn->num($sql) != 0 ) $ocupado++;

		$h++;
	}
}

if ($ocupado<2){
	$data['ocupado']=false;
	$sql= "INSERT INTO data (Agenda,IdUsuario,Fecha,Obs,UsuarioCogeCita) VALUE ($agenda,$userId,'$fecha','$nota',".$_SESSION['id_usuario'].")";
	if ($conn->query($sql)){
		$idServicio = $conn->id();
		$data['idCita'] = $idServicio ;
		
		for ($i = 0; $i < count($servi); $i++) {

			$sql= 'SELECT A.Tiempo FROM articulos A WHERE Id  = '. $servi[$i].' LIMIT 1';
			$ser= $conn->array($sql);

			$unidades_t = ceil(($ser['Tiempo'] / 15));

			$sql="";
			for ($a = 1; $a <= ($unidades_t); $a++) {
				
				$sql = 'INSERT INTO cita (IdCita, Hora, Servicio) VALUE ('.$idServicio.',FROM_UNIXTIME("' . $hora . '"),'. $servi[$i].')';
				if(!$conn->query($sql)){
					$data['success']=false;
					 mnsExit($sql);
					 break;
				}else{
					$data['id'][]= $conn->id();
				}

				$hora = strtotime ( '+15 minute' ,  $hora ) ;

			}
		}
	}else{$data['err']=$sql;}
}else{
	$data['ocupado']=true;
}

if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");
//registrarEvento(1, $idServicio,$_SESSION['id_usuario'],$agenda);
echo json_encode($data);