<?php
include "connect/conexion.php";

if (isset($_GET['idUsuario']))	$idUsuario = $_GET['idUsuario'];
if (isset($_GET['apellidos'])) {
	$Nombre = Trim($_GET["nombre"])  . " " . (Trim($_GET['apellidos']));
}else{
	$Nombre = Trim($_GET["nombre"]) ;
}
$Email  = Trim($_GET["email"]);
	
	if ($Email=="undefined"){
		header "index.php";
	}else{
		if (isset($_GET["pass"])) 	$Pass   = Trim($_GET["pass"]);
		if (isset ($_GET['tel']))		$Tel    = $_GET['tel'];

		//Usuario nuevo de Facebook
		$usuario = htmlentities($_GET['usuario'], ENT_QUOTES,'UTF-8');
		$email    = htmlentities($_GET['email'], ENT_QUOTES,'UTF-8');

	if(mysqli_query($conexion,"INSERT INTO usuarios (Id,Nombre,Email,Pass,Tel,Admin,Obs) VALUE ('','$usuario','$email','i3468294979','','0','Fb');")){
		$_SESSION['id_usuario'] = $row_login["Id"];
		registrarEvento(3, 0, $row_login["Id"],0); 
		header("Location: ../index.html");
	}else{
		?><script>alert("Error al guardar el usuario");<?php
	}
}
?>


