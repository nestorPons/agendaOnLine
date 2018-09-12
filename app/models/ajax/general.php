<?php
$Admin = new core\BaseClass('admin', 'aa_db');
$Empresa = new core\BaseClass('empresas','aa_db') ;
$err = false; 

$email = $_POST['email'];
$tel = $_POST['tel'];
$web = $_POST['web'];
unset($_POST['email'],$_POST['tel'],$_POST['web']);

if($r['success']  = $Empresa->saveById(CONFIG['idEmpresa'] , ['email'=>$email, 'tel'=>$tel, 'web'=>$web] )){
	$Logs->set( $_SESSION['id_usuario'], $_POST['action'], 1, $_POST['controller']);
}else $r['err'] = 'guardando email';

echo json_encode($r) ;