<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion(true,false,true);

$chck = $_POST['chck']??-1;
for ($i=0;$i<=CONFIG['NumAg']-1;$i++){
	$a = $i+1;
	$sql = "SELECT Id FROM agendas WHERE Id =". $a ;
	$row=mysqli_num_rows(mysqli_query($conexion,$sql));
	$mostrar = ($chck==-1)?0:in_array($a,$chck)?1:0;
	$nombre = ($_POST['nombre'][$i])??"Agenda$a";
	$sql = ($row>0)
	?"UPDATE agendas SET Nombre ='$nombre', Mostrar=$mostrar WHERE Id=$a"
	:"INSERT INTO agendas (Nombre,Mostrar) VALUES ('$nombre',$mostrar)";

	$js['success']=mysqli_query($conexion,$sql)?true:false;
}
echo json_encode($js);