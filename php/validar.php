<?php
session_start ();
$empresa =  $_POST['empresa']??$_SESSION['bd'];
$_SESSION['bd'] = $empresa ;
require "connect/clsConfig.php";

$_SESSION['esMobil'] = ($_POST['ancho']<=590)?1:0;

if(isset($_POST["login"])&&isset($_POST['pass'])){
		//LOGIN WEB
	$sql = "SELECT * FROM usuarios WHERE Email LIKE '". $_POST["login"]."';";

	if ($r= $conn->assoc($sql)){
		if($r["Pass"] === $_POST["pass"]){
			if ($r["dateBaja"]==0){
				usuarioRegistrado($r["Id"],$r['Admin'],$r['dateBaja'],$r["Nombre"],$r["Email"], $r["Tel"]);
			}else{err('Cuenta bloqueada. Consulte su email.');}
		}else{err('La contraseña no coincide.');}
	}else{err('Usuario no registrado.');}

}else if(isset($_COOKIE["PHPSESSID"])&&isset($_COOKIE["marca"])){

	$sql = "SELECT Id,Admin,dateBaja FROM usuarios WHERE cookie = ".$_COOKIE["marca"].";";
	if($row = $conn->row($sql)){
		$activa = !empty($row[2]);
		usuarioRegistrado($row[0],$row[1],$activa,$row[3],$row[4],$row[5]);
	}else{err('noEnc');}

}

function usuarioRegistrado(&$idUsuario,&$permisoAdministrador,&$activa){
	global $bd; 
	global $empresa;
	$_SESSION['id_usuario'] = $idUsuario;

	if(isset($_POST['recordar'])){crearCookie($idUsuario);}

	if ($permisoAdministrador==1){
		$_SESSION['admin_sesion']=1;
		header ("location: admin/index.php");
	}else{
		$url = $activa?err('Cuenta inactiva'):"../".$empresa."/users/index.php";
		header ("Location: $url");//REDIRIJO A USUARIOS BLOQUEADOS
	}
}

function crearCookie($id){
	global $conn;
	if($_POST["recordar"] == true){
		mt_srand(time());
		$rand = mt_rand(1000000,9999999);
		$conn->query("UPDATE usuarios SET cookie=".$rand.$id." WHERE Id=$id");
		setcookie("id_user", $id, time()+(60*60*24*60),"/");
		setcookie("marca", $rand . $id, time()+(60*60*24*60),"/");
	}
	return true;
}
function err($err){
	global $empresa;
	include "connect/destroysession.php";
	header("location:../empresas/$empresa?closeSession=1&err=".$err);
}
