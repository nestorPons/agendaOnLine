<?php
$validar=true;
include "connect/conexion.php";
$conexion = conexion();

 $nombre=trim(htmlspecialchars($_GET["nombre"]));
 $email= trim($_GET['email']);
 $id= $_GET['id'];
$_SESSION['email']  = $email;
$_SESSION['nombre']	= $nombre;
if ($email=='undefined'){
	echo 'No se puede acceder con facebook, pongase en contacto con el administrador';
	exit;	
}
function usuarioRegistrado($idUsuario,$permisoAdministrador,$bloqueado){
    $_SESSION['id_usuario'] = $idUsuario;
	registrarEvento(0,0, $idUsuario,0);
    if ($permisoAdministrador==1){
         header("location:../admin/agendas/agendas.php?agenda=0");
    }else{
        if($bloqueado==1){
            //REDIRIJO A USUARIOS BLOQUEADOS
            header("location:../users/block.html");
        }else{
			header("location:../users/index.php");  
        }
    }
}
$sql="SELECT * FROM usuarios WHERE Email LIKE '$email'";
$result = mysqli_query($conexion,$sql);
$row= mysqli_fetch_array($result);
if (isset($row)){
		usuarioRegistrado($row["Id"],$row['Admin'],$row['Block']);
}else{
	header("location:guardar.php?nombre=$nombre&email=$email&id=$id");
}
 ?>