<?php 
define ('DS'  , DIRECTORY_SEPARATOR);
define('ROOT' ,realpath(dirname(__FILE__)). DS);
$_SESSION['CONFIG']  = CONFIG;
//HORARIOS																																																																
include (ROOT . 'horarios/consult.php');
define('HORAS',Horarios\horarios());
$_SESSION['HORAS'] = HORAS;

define('MARGEN_DIAS',10);

function familias(){
	global $conexion;
	
	$sql= "SELECT * FROM familias ORDER BY Nombre ASC";
	$result= mysqli_query($conexion,$sql);
	return mysqli_fetch_all($result,MYSQLI_NUM);
}
$_SESSION['FAMILIAS'] = familias();

function servicios(){
	global $conexion;
	
	$sql="SELECT * FROM articulos WHERE Baja = 0 ORDER BY Descripcion";
	$result= mysqli_query($conexion,$sql);
	return mysqli_fetch_all($result,MYSQLI_NUM);
}
$_SESSION['SERVICIOS'] = servicios();

function usuarios(){
	global $conexion;
	
	$sql="SELECT * FROM usuarios ORDER BY Nombre";
	$result= mysqli_query($conexion,$sql);
	return mysqli_fetch_all($result);
}
//AKI : HAY que refrescar datos usuario cuado un usuario actualice o nuevo 
$_SESSION['USUARIOS'] = usuarios();

//FESTIVOS
function festivos(){
	global $conexion;
	
	$sql="SELECT * FROM festivos";
	$resultf = mysqli_query($conexion, $sql);
	while ($rowf=mysqli_fetch_array($resultf)){
		$date =new DateTime($rowf['Fecha']);
		$date = date_format($date,"md");
		$data['festivos'][]=$date;	
	}

	return $data['festivos']??false;
}

//AGENDA
function datosAgenda($fecha){
	global $conexion;
	
	$dias = MARGEN_DIAS;
	$fchIni =date ( 'Y-m-d', strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) );
	$fchFin =date ( 'Y-m-d', strtotime ( '-'.$dias.' day' , strtotime ( $fecha ) ) );

	$sql = 'SELECT C.Id, A.Codigo, D.Agenda, D.IdCita, D.IdUsuario, U.Nombre, D.Obs, C.Hora , D.Fecha ,A.Tiempo, A.Id AS IdCodigo
		FROM cita C JOIN data D ON C.IdCita = D.IdCita 
		INNER JOIN usuarios	U ON D.IdUsuario = U.Id 
		LEFT JOIN articulos A ON C.Servicio = A.Id  
		WHERE D.Fecha BETWEEN "'.$fchFin.'" AND "'.$fchIni.'"  
		ORDER BY D.Fecha, D.Agenda, C.Hora';

	$result=mysqli_query($conexion,$sql);
	$data['agenda']=mysqli_fetch_all($result,MYSQLI_ASSOC);

	//acomodo un array para la consulta php de inicio
	for($i=0;$i<count($data['agenda']);$i++){
		for ($x= 0 ; $x <=5 ;$x++){		
			$fecha  = $data['agenda'][$i]['Fecha'];
			$hora =  strtotime($data['agenda'][$i]['Hora']);
			$agenda = $data['agenda'][$i]['Agenda'];
			
			if (!isset($datosAgenda[$fecha][$hora][$agenda][$x])){
				$datosAgenda[$fecha][$hora][$agenda][$x]
					= array(
						'id'=>$data['agenda'][$i]['Id'],
						'idCita'=>$data['agenda'][$i]['IdCita'],
						'codigo'=>$data['agenda'][$i]['Codigo'],
						'idCodigo'=>$data['agenda'][$i]['IdCodigo'],
						'tiempo'=>$data['agenda'][$i]['Tiempo'],
						'obs'=>$data['agenda'][$i]['Obs'],
						'idUsuario'=>$data['agenda'][$i]['IdUsuario'],
						'nombre'=>$data['agenda'][$i]['Nombre']
					);
					break;
			}
		}
	}
	//RESET TABLA CITA_USER

	//mysqli_query($conexion,"TRUNCATE cita_user");
	
	return $datosAgenda??false;
}
$datosAgenda = datosAgenda(Date('Y-m-d'));
$_SESSION['AGENDAS'] = $datosAgenda;