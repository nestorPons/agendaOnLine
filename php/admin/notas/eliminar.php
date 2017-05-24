<?php
include "../../../../connect/conexion.php";
$fecha = $_POST['fecha'];
$ArrayFecha =explode('/', $fecha );
$fecha = trim($ArrayFecha[2]) . "-". trim($ArrayFecha[1]) . "-". trim($ArrayFecha[0]);
$SQL= ("DELETE FROM notas WHERE Fecha = '$fecha'");
mysqli_query($conexion,$SQL);
?>