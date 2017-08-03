<?php
header('Content-Type: application/json');
require "../../connect/config.controller.php";

$chck = $_POST['chck']??-1;
for ($i=0;$i<=CONFIG['NumAg']-1;$i++){
	$a = $i+1;
	$sql = "SELECT Id FROM agendas WHERE Id =". $a ;
	$row=$conn->row($sql);
	$mostrar = ($chck==-1)?0:in_array($a,$chck)?1:0;
	$nombre = ($_POST['nombre'][$i])??"Agenda$a";
	$sql = ($row>0)
	?"UPDATE agendas SET Nombre ='$nombre', Mostrar=$mostrar WHERE Id=$a"
	:"INSERT INTO agendas (Nombre,Mostrar) VALUES ('$nombre',$mostrar)";

	$js['success']=$conn->query($sql);
}
echo json_encode($js);