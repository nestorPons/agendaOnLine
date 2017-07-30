<?php 
define ('DS'  , DIRECTORY_SEPARATOR);
define('ROOT' ,realpath(dirname(__FILE__)). DS);
$_SESSION['CONFIG']  = CONFIG;

//HORARIOS																																																																
include (ROOT . 'horarios/consult.php');
define('HORAS',horarios\horarios());
//$_SESSION['HORAS'] = HORAS;

define('MARGEN_DIAS',10);

function familias(){
	global $conn;
	// 0 IdFamilia 1 Nombre 2 Mostrar 3 Baja
	return $conn->all("SELECT * FROM familias  ORDER BY Nombre");
}
$_SESSION['FAMILIAS'] = familias();

function servicios(){
	global $conn;
	//	0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
	return $conn->all("SELECT * FROM articulos  ORDER BY Codigo",MYSQLI_NUM);
}
$_SESSION['SERVICIOS'] = servicios();

function usuarios(){
	global $conn;

	return $conn->all("SELECT * FROM usuarios ORDER BY Nombre");
}
 
$_SESSION['USUARIOS'] = usuarios();

//AGENDA
function datosAgenda($fecha){
	global $conn;
	
	$dias = MARGEN_DIAS;
	$fchIni =date ( 'Y-m-d', strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) );
	$fchFin =date ( 'Y-m-d', strtotime ( '-'.$dias.' day' , strtotime ( $fecha ) ) );

	$sql = "SELECT D.IdCita, A.Id AS IdCodigo, A.Codigo, D.Agenda, D.IdUsuario, U.Nombre, D.Obs, D.Hora , D.Fecha ,A.Tiempo, A.Descripcion
		FROM cita C JOIN data D ON C.IdCita = D.IdCita 
		INNER JOIN usuarios	U ON D.IdUsuario = U.Id 
		LEFT JOIN articulos A ON C.Servicio = A.Id  
		WHERE D.Fecha BETWEEN '$fchFin' AND '$fchIni'  
		ORDER BY D.IdCita, D.Hora";

	$data=$conn->all($sql,MYSQLI_ASSOC);
	if (count($data)>0) {

		for( $i = 0 ; $i < count($data) ; $i++ ){
			if (!isset($datosAgenda[$data[$i]['IdCita']])){
				$datosAgenda[$data[$i]['IdCita']] 
				= array(
					'idCita'=>$data[$i]['IdCita'],
					'fecha'=>$data[$i]['Fecha'],
					'hora'=>$data[$i]['Hora'],
					'agenda'=>$data[$i]['Agenda'],
					'obs'=>$data[$i]['Obs'],
					'idUsuario'=>$data[$i]['IdUsuario'],
					'nombre'=>$data[$i]['Nombre'],
					'tiempo_total'=> 0,
					'servicios' => array()
				);
			}
			$datosAgenda[$data[$i]['IdCita']]['tiempo_total'] += (int)$data[$i]['Tiempo'] ;
			$datosAgenda[$data[$i]['IdCita']]['servicios'][] = array(
				'idCodigo'=>$data[$i]['IdCodigo'],
				'codigo'=>$data[$i]['Codigo'],
				'des'=>$data[$i]['Descripcion'],
				'tiempo'=> $data[$i]['Tiempo']
			);
		
		}
		foreach($datosAgenda as $key => $value){
				$fecha =  str_replace('-', '', trim($value['fecha'])) ;
				$agenda = $value['agenda'];
				$hora = strtotime($value['hora']);
				$arr_data[$fecha][$agenda][$hora] = $value;

		}

	} else {
		$datosAgenda = null;
	}
	//RESET TABLA CITA_USER
	$conn->query("TRUNCATE user_reg");
	
	return $arr_data??false;
}
$datosAgenda = datosAgenda(Date('Y-m-d'));