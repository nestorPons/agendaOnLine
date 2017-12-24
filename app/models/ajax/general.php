<?php
$Forms = new models\Forms; 
$_POST = $Forms->sanitize($_POST);

$Admin = new core\BaseClass('admin', 'aa_db');
$Empresa = new core\BaseClass('empresas','aa_db') ;
$err = false; 
if ($Forms->validateForm($_POST)){

	$email = $_POST['email'];
	$tel = $_POST['tel'];
	$web = $_POST['web'];
	unset($_POST['email'],$_POST['tel'],$_POST['web']);

	if($r['success']  = $Empresa->saveById(CONFIG['idEmpresa'] , ['email'=>$email, 'tel'=>$tel, 'web'=>$web] )){
		if($idAdmin = $Empresa->getById(CONFIG['idEmpresa'], 'idAdmin')){
			if (!$r['success'] = $Admin->saveById($idAdmin , $_POST ))
				$r['err'] = Error::E030;
		}
	}else $r['err'] = 'guardando email';
	
}else $r['success'] = false;

echo json_encode($r) ;