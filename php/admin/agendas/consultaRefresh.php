<?php 
header('Content-Type: application/json');
require_once "../../connect/conexion.php";
$conexion = conexion();


//ELIMINAR REGISTROS DE LA TABLA CONTROL CITAS USUARIOS (CITA_USERS)
//CONSULTA DE INSERTADAS
if(isset($_GET['ins'])){
	foreach ($_GET['ins'] as $idCita){
		//$idCita = $_GET['data'][$i];
			
		$sql = 'SELECT C.Id, D.IdCita,  D.Fecha , C.Hora ,D.IdUsuario, U.Nombre, A.Id AS IdCodigo, A.Codigo, A.Tiempo , D.Agenda,  D.Obs 
		FROM cita C JOIN data D ON C.IdCita = D.IdCita 
		INNER JOIN usuarios U ON D.IdUsuario = U.Id 
		LEFT JOIN articulos A ON C.Servicio = A.Id 
		WHERE D.IdCita ='.$idCita;

		$sql = preg_replace("/\r\n+|\r+|\n+|\t+/i", "", $sql);
		
		$result = mysqli_query($conexion,$sql);
		if($data['ins'][$idCita] = mysqli_fetch_array($result,MYSQLI_NUM)) 
			delConsult($idCita);

	}	
}

//CONSULTA DE ELIMINADAS
if(isset($_GET['del'])){
	
	foreach ($_GET['del'] as $idCita){
		
		$sql = 'SELECT DISTINCT C.Servicio FROM del_cita C JOIN del_data D ON C.IdCita = D.IdCita WHERE D.IdCita = '.$idCita;
			
		$result = mysqli_query($conexion,$sql);
		if ($data['del'][$idCita] = mysqli_fetch_all($result,MYSQLI_NUM))
			delConsult($idCita);

	}
}

echo json_encode($data);

function delConsult($idCita){
	global $conexion;
	$sql = 'DELETE FROM cita_user WHERE idCita ='.$idCita;
	return mysqli_query($conexion,$sql);
}