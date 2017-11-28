<?php
header('Content-Type: application/json');

for($d=0;$d<CONFIG['margen_dias'];$d++){
	$fecha = strtotime ( '+'. $d .' day' , strtotime ( date($_POST['f']) ) ) ;
	$diaSemana =  date("N",strtotime($fecha));
	$key = date('Ymd',$fecha);

	$rows = $Users->getBySQL("'" . date( 'md' ,  $fecha)."' BETWEEN horarios.fechaIni AND horarios.fechaFin");
	unset($rows['id'],$rows['nombre'],$rows['fechaIni'],$rows['fechaFin']);
	
	foreach ($rows	as $clave=>$valor) {
		if($clave[1]==$diaSemana&&!empty($valor)) 
			$horas[$key][substr($clave, 2)]=(int)$valor[0];
	}		
    
	$sql='SELECT C.hora FROM cita C JOIN data D ON C.idCita = D.idCita WHERE D.fecha = "'.date('Y-m-d',$fecha).'" AND agenda ='.$_GET['a'];
	$result	= mysqli_query($conexion,$sql);
	$datos = mysqli_fetch_all($result, MYSQLI_NUM);
	
	foreach ($datos as $clave=>$valor) {
		if (isset($horas[$key])&& array_key_exists($valor[0],$horas[$key]))
			$horas[$key][$valor[0]] = 2;
	}
	
}
echo json_encode($horas);