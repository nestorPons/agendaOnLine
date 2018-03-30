<?php
$Familias = new core\BaseClass('familias');
header('Content-Type: application/json');

$id = $_POST['id']??-1;
$r['nombre'] = isset($_POST['nombre']) ? $_POST['nombre'] : exit ;
$r['mostrar'] = isset($_POST['mostrar']) ? 1 : 0 ;
$r['baja'] = $_POST['baja']??0;

$r['success'] = $Familias->saveById($id , $r ) ;
$r['id'] = $id==0 ? $Familias->getId() : $id ;
$_SESSION['FAMILIAS'] = $Familias->getAll() ;

echo json_encode($r) ;