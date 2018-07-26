<?php
$Forms::sanitize($_POST);

$r['success']=true;
$userId = $_POST['cliente'];

$fecha =$_POST['fecha']??mnsExit('Sin fecha');
$hora = date('H:i',strtotime($_POST['hora']))??mnsExit('Sin hora');

$servicios = $_POST['servicios']??mnsExit('No se han pasado servicios');
$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');

$r['success']=true;

$data = $Data->getBy(array('fecha','hora','agenda'),array($fecha, $hora, $agenda)); 

if ($data <= 1 || 1 ){
	$r['ocupado']=false;
	if($Data->saveById(-1,[
			'agenda' => $agenda,
			'idUsuario' => $userId,
			'fecha' => $fecha,
			'hora' => $hora, 
			'obs' => $_POST['nota']??"", 
			'usuarioCogeCita' => $_SESSION['id_usuario'],
			'tiempo_servicios' => $_POST['tiempoServicios']
		])){
		
			$id_servicio = $Data->getId();
			$sql = '';

			foreach ($servicios as $id ) {
					$Cita->saveById(-1,[
							'idCita' =>$id_servicio, 
							'servicio'=> $id
						]);

					$arrSer[] = $Serv->getById($id) ;
					$arridCitaSer[] = $Data->getId();
				}

			$r['idUser'] = $userId ;
			$r['idCita'] = $id_servicio ;
			$r['services'] = $arrSer ;
			$r['idCitaSer'] = $arridCitaSer;

 

			if($User->isUser() && CONFIG['sendMailUser'] ){
		
				$User->sendMail(
					'mailConfirmation.php', 
					'Confirmación reserva', 
					[$fecha,$hora, $_POST['tiempoServicios']]
				);
				
			}
		}
} else {
	$r['ocupado']=true;
	$r['mns']['tile'] = " hora ocupada " ;
	$r['mns']['body'] = " No se pueden reservar dos citas en la misma hora " ;
	}

function mnsExit($mns){
	echo($mns);
	exit();
}