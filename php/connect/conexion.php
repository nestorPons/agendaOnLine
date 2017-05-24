<?php
if (strlen(session_id()) < 1)
	session_start ();

header("Content-Type: text/html;charset=utf-8");
ini_set('session.cookie_lifetime',43200);
date_default_timezone_set("Europe/Madrid");

define('MARGEN_DIAS',10);

function conexion ( $security=true,$bd=false,$tools = false){ 
		
	$bd = $bd!=false?$bd:$_SESSION['bd'];
	
	if ($security) {		include "security.php";		}
	
	$user = "user";
	$pass = "0Z8AHyYDKN0hUYik";
	
	$conn = mysqli_connect("localhost",$user,$pass,'bd_'.$bd)
		or die ("Error conexion 001 =>" . mysqli_connect_error(). PHP_EOL);

	if ($tools)	{ 		include 'config.php';	}	
	
	return $conn ;
}