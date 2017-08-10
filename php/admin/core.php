<?php 
$_SESSION['CONFIG'] = CONFIG ;
//HORARIOS																																																																
include (dirname(__FILE__) . '/horarios/controller.php');
define('HORAS',$horarios->hours());

define('MARGEN_DIAS',3);

function familias(){
	global $conn;
	// 0 IdFamilia 1 nombre 2 Mostrar 3 Baja
	return $conn->all("SELECT * FROM familias  ORDER BY nombre");
}
$_SESSION['FAMILIAS'] = familias();

function servicios(){
	global $conn;
	//	0 Id 1 codigo 2 descripcion 3 Precio 4 tiempo 5 IdFamilia 6 Baja
	return $conn->all("SELECT * FROM articulos  ORDER BY codigo",MYSQLI_NUM);
}
$_SESSION['SERVICIOS'] = servicios();

function usuarios(){
	global $conn;

	return $conn->all("SELECT * FROM usuarios ORDER BY nombre");
}
 
$_SESSION['USUARIOS'] = usuarios();