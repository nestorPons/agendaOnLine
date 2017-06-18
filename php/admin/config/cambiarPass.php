<?php 
header('Content-Type: application/json');
include "../../connect/conexion.php"; 
$conexion = conexion();

//comprobar contraseña antigua
$old_pass = sha1(trim($_POST['oldPass']));
$sql="SELECT Pass FROM usuarios WHERE Id =".$_SESSION['id_usuario'];
$result = mysqli_query($conexion,$sql);
$bd_pass = mysqli_fetch_row($result);
if ($bd_pass[0]==$old_pass){
	$pass = $_POST['newPass'];
	$usuario = $_SESSION['id_usuario'];
	$sql="UPDATE usuarios SET Pass = '$pass' WHERE Id = $usuario";	
	$js['respond']=($js['success'] = mysqli_query($conexion,$sql))?"Ok":"No se pudo guardar el registro!!";
}else{
	$js['success'] = false;
	$js['respond'] = 'Anterior contraseña no corresponde';
}
echo json_encode($js);