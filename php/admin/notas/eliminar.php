<?php
include "../../../../connect/conexion.php";
$fecha = $_POST['fecha'];
$Arrayfecha =explode('/', $fecha );
$fecha = trim($Arrayfecha[2]) . "-". trim($Arrayfecha[1]) . "-". trim($Arrayfecha[0]);
$SQL= ("DELETE FROM notas WHERE fecha = '$fecha'");
mysqli_query($conexion,$SQL);
?>