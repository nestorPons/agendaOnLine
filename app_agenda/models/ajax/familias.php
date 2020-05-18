<?php header('Content-Type: application/json');
$Familias = new core\BaseClass('familias');

$id = $_POST['id']??-1;
$r['nombre'] = isset($_POST['nombre']) ? $_POST['nombre'] : exit ;
$r['mostrar'] = isset($_POST['mostrar']) ? 1 : 0 ;
$r['baja'] = $_POST['baja']??0;

$r['success'] = $Familias->saveById($id , $r ) ;
$r['id'] = $id==-1 ? $Familias->getId() : $id ;
$_SESSION['FAMILIAS'] = $Familias->getAll() ;

$Logs->set( $_SESSION['id_usuario'], $_POST['action'], $r['id'], $_POST['controller']);
echo json_encode($r) ;