<?php 
require "../../connect/conexion.php";
require "../../libs/horario.php";
$cns ="";
$count = count(HORAS);
$sql = "INSERT horarios (Nombre,FechaIni,FechaFin) VALUES ('General','0101','1231')";
mysqli_query($conexion,$sql);
for($a=0;$a<=$count;$a++){
	for($d=1;$d<=7;$d++){
		$sql="INSERT INTO horas (Horarios,Dia) VALUES ('1',$d);";
		mysqli_query($conexion,$sql);
	}
}