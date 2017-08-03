<?php
require "../../connect/conn.controller.php";

$email = (!empty($_POST['email']))?trim($_POST['email']):"" ;
$tel = (!empty($_POST['tel']))?trim($_POST['tel']):"" ;
$nif = $_POST['nif']??"" ;
$dir = $_POST['dir']??"" ;
$poblacion = $_POST['poblacion']??"" ;
$pais = $_POST['pais']??"" ;
$cp = $_POST['cp']??"" ;
$web = $_POST['web']??"" ;

$sql ="UPDATE empresas 
	SET Email= '$email', NIF = '$nif', Tel = '$tel', Dir='$dir', Poblacion = '$poblacion',Pais = '$pais',CP = '$cp',Web = '$web' 
	WHERE Id = ". CONFIG['Id'];

$r['success'] = $conf->query($sql) ;

echo json_encode($r) ;