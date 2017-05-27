<?php 
header('Content-Type: application/json');
include  "../../connect/conexion.php";
$conexion = conexion();

$f = $_GET['f'];
$sql="SELECT * FROM horarios WHERE  $f BETWEEN horarios.fechaIni AND horarios.fechaFin;";
$js['sql'] =$sql;
$result = mysqli_query($conexion, $sql);
if($row = mysqli_fetch_assoc($result)){
	$js['success']=true;
	unset($row['id'],$row['nombre'],$row['fechaIni'],$row['fechaFin']);
	$js['row']=$row;
}else{
	$js['success']=false;
}
echo json_encode($js);