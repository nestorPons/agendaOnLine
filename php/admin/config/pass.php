<?php 
header('Content-Type: application/json');
include "../../connect/clsConexion.php"; 

$bd_pass = $conn->row("SELECT Pass FROM usuarios WHERE Id =".$_SESSION['id_usuario']." LIMIT 1")[0] ;

if ( $bd_pass == $_POST['oldPass'] ){
	$sql = 'UPDATE usuarios SET Pass = "'. $_POST['newPass'] .'" WHERE Id ='.$_SESSION['id_usuario'] ;
	$js['success'] =  $conn->query( $sql ) ;
	$js['respond']=($js['success'] == true)? "Contraseña guardada con éxito.": $js['success'] ;
}else{
	$js['success'] = false;
	$js['respond'] = 'La contraseña antigua no es la misma.';
}
echo json_encode($js);