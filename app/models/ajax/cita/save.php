<?php
$Forms::sanitize($_POST);

$r['success']=true;
$userId = $_POST['cliente'];

$fecha =$_POST['fecha']??mnsExit('Sin fecha');
$hora = date('H:i',strtotime($_POST['hora']))??mnsExit('Sin hora');

$servicios = $_POST['servicios']??mnsExit('No se han pasado servicios');
$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');

$r['success']=true;
$sql = "SELECT * FROM data WHERE fecha = '$fecha' AND hora = '$hora' AND agenda= '$agenda'";
$result_data = $conn->row($sql) ;

if ($result_data <= 1 || 1 ){
	$r['ocupado']=false;
	if($Data->saveById(0,[
			'agenda' => $agenda,
			'idUsuario' => $userId,
			'fecha' => $fecha,
			'hora' => $hora, 
			'obs' => $_POST['nota']??"", 
			'usuarioCogeCita' => $_SESSION['id_usuario']
		])){
		
		$id_servicio = $Data->getId();
		$sql = '';

		foreach ($servicios as $id ) {
				$Cita->saveById(0,[
						'idCita' =>$id_servicio, 
						'servicio'=> $id
					]);

				$arrSer[] = $Serv->getById($id) ;
				$arridCitaSer[] = $conn->id();
			}

		$r['idUser'] = $userId ;
		$r['idCita'] = $id_servicio ;
		$r['services'] = $arrSer ;
		$r['idCitaSer'] = $arridCitaSer;
		}
} else {
	$r['ocupado']=true;
	$r['mns']['tile'] = " hora ocupada " ;
	$r['mns']['body'] = " No se pueden reservar dos citas en la misma hora " ;
	}

//AKI :: hay que implementar los email de aviso
//if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");

function mnsExit($mns){
	echo($mns);
	exit();
}