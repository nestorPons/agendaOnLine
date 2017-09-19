<?php

if ($_POST){

	$userId = $_POST['cliente'];

	$fecha =$_POST['fecha']??mnsExit('Sin fecha');
	$hora = date('H:i',strtotime($_POST['hora']))??mnsExit('Sin hora');

	$servicios = $_POST['servicios']??mnsExit('No se han pasado servicios');
	$agenda =  $_POST['agenda'][0]??mnsExit('Sin agenda');
	$nota = $_POST['nota']??"";

	$r['success']=true;
	$sql = "SELECT * FROM data WHERE fecha = '$fecha' AND hora = '$hora' ";
	$result_data = $conn->row($sql) ;

	if ($result_data <= 1 ){
		$r['ocupado']=false;
		$sql= "INSERT INTO data (agenda,idUsuario,fecha,hora,obs,usuarioCogeCita) VALUE ('$agenda','$userId','$fecha', '$hora' ,'$nota','".$_SESSION['id_usuario']."')";
		if ($conn->query($sql)){
			$id_servicio = $conn->id();

			$sql = '';
			
			foreach ($servicios as $id ) {
				$sql .= 'INSERT INTO cita (idCita, servicio) VALUE ('.$id_servicio.','. $id.') ; ';
				$arrSer[] = $Serv->getById($id) ;
			}

			$conn->multi_query($sql) ;
			$r['idUser'] = $userId ;
			$r['idCita'] = $id_servicio ;
			$r['services'] = $arrSer ;

		}
	} else {
		$r['ocupado']=true;
		$r['mns']['tile'] = " hora ocupada " ;
		$r['mns']['body'] = " No se pueden reservar dos citas en la misma hora " ;
	}

} else {
	$r = false ;
}
//if (CONFIG['sendMailAdmin']) include ("../../libs/enviarEmail.php");
//registrarEvento(1, $idServicio,$_SESSION['id_usuario'],$agenda);


function mnsExit($mns){
	echo($mns);
	exit();
}