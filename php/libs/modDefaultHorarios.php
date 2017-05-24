<?php
require "connect/conexion.php";
$conexion = conexion();

	//filtro para la primera vez que se habre horarios
		$sql = "SELECT * FROM horarios";
		$row = mysqli_fetch_row(mysqli_query($conexion,$sql));
		if (empty($row)){ 
			mysqli_query($conexion,"INSERT INTO horarios (Id) VALUES (0)");
		}
		//**