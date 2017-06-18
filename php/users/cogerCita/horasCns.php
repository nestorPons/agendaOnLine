<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

for($d=0;$d<MARGEN_DIAS;$d++){
	$fecha = strtotime ( '+'. $d .' day' , strtotime ( date($_GET['f']) ) ) ;
	$diaSemana =  date("N",strtotime($fecha));
	$key = date('Ymd',$fecha);
	
	$sql = "SELECT * FROM horarios WHERE '".date( 'md' ,  $fecha)."' BETWEEN horarios.fechaIni AND horarios.fechaFin";
	$rows = mysqli_fetch_assoc(mysqli_query($conexion,$sql));
	unset($rows['Id'],$rows['Nombre'],$rows['FechaIni'],$rows['FechaFin']);
	
	
	foreach ($rows	as $clave=>$valor) {
		if($clave[1]==$diaSemana&&!empty($valor)) 
			$horas[$key][substr($clave, 2)]=(int)$valor[0];
	}		

	$sql='SELECT C.Hora FROM cita C JOIN data D ON C.IdCita = D.IdCita WHERE D.Fecha = "'.date('Y-m-d',$fecha).'" AND Agenda ='.$_GET['a'];
	$result	= mysqli_query($conexion,$sql);
	$datos = mysqli_fetch_all($result, MYSQLI_NUM);
	
	foreach ($datos as $clave=>$valor) {
		if (isset($horas[$key])&& array_key_exists($valor[0],$horas[$key]))
			$horas[$key][$valor[0]] = 2;
	}
	
}
echo json_encode($horas);