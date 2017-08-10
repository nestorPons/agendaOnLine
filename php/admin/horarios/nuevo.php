<?php 
//header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

require "../../libs/horario.php";
$cns ="";
$count = count(HORAS);
for($a=1;$a<=7;$a++){
	for($i=1;$i<=$count;$i++){
		$cns.="h$a$i tinyint(1) DEFAULT 0,";
	}	
}
$sql = "CREATE TABLE horarios (id INT NOT NULL AUTO_INCREMENT, nombre char(10),fechaIni INT(4) zerofill ,fechaFin INT(4) zerofill ,$cns PRIMARY KEY (id));";
$std= mysqli_query($conexion,$sql)?'true':'false';
echo $std;
$sql="INSERT INTO horarios (nombre,fechaIni,fechaFin) VALUES ,('General',0101,1231),('Invierno',0000,0000),('Verano',0000,0000),('horario 1',0000,0000),('horario 2',0000,0000);";
$std= mysqli_query($conexion,$sql)?'true':'false';
echo $std;
?>