<?php 
if (empty($_SESSION['bd'])||empty($_SESSION['id_usuario'])){
	echo "ERROR SEGURIDAD ";
	require "destroysession.php";
	//header("Location:../");
	exit;
}