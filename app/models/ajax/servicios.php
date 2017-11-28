<?php
header('Content-Type: application/json');
$Servicios = new core\BaseClass('servicios');

$id= $_POST['id']??0;

$r = [
	'codigo' => $_POST['codigo']??exit, 
	'descripcion' => trim($_POST['descripcion']) , 
	'tiempo' => $_POST['tiempo']??10 , 
	'precio' => $_POST['precio']??0 , 
	'idFamilia' => $_POST['idFamilia']??1 ,
	'baja' => $_POST['baja']??0
];

$r['success']  = $Servicios->saveById($id , $r);
$r['id'] =  ($id == 0 ) ? $Servicios->getId() : $id ;
$_SESSION['SERVICIOS'] = $Servicios->getAll() ;

echo json_encode($r) ;
