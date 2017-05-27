<?php
require_once "../../connect/conexion.php";
$_SESSION['servicios']  = $_POST["servicios"];
$agenda = $_SESSION['crearCita']['agenda'];

$TiempoServicios = 0;
$servi = $_SESSION['servicios'];
for ($i = 0; $i < count($servi); $i++) {
	$servicios = $servi[$i];
	$sql="SELECT * FROM articulos WHERE Codigo LIKE '$servicios'";
	$result_t = mysqli_query($conexion,$sql);
	$fila_id_t= mysqli_fetch_array($result_t);
	$TiempoServicios +=  ($fila_id_t["Tiempo"] / 15);
}
$_SESSION['crearCita']['tSer'] = $TiempoServicios;

$link = !empty($_SESSION['crearCita']['fecha'])?'guardar.php':'calendario.php';
$query_id= "SELECT * FROM cita$agenda ORDER BY IdCita DESC LIMIT 1";
$result_id = mysqli_query($conexion, $query_id);
if ($fila_id= mysqli_fetch_array($result_id)){
	$id_fila = $fila_id["IdCita"]+1;
}
header("location:$link");