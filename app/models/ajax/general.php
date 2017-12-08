<?php 
$Admin = new core\BaseClass('aa_db' , 'admin') ;
$Empresa = new core\BaseClass('aa_db' , 'empresa') ;
$err = false; 
foreach($_POST as $key => $val){
	if(empty($val)) {
		$err = true; 
		break;
	}
}
if (!$err){
	/*
	$admin = [
		'nombre_usuario'=>$_POST['nombre_usuario'] ,
		'email' => $_POST['email'] ,
		'dni' => $_POST['dni'] ,
		'dir' => $_POST['dir'] ,
		'poblacion' => $_POST['poblacion'] ,
		'provincia' => $_POST['provincia'] ,
		'pais' => $_POST['pais'],
		'cp' => $_POST['cp'],
		'web' => $_POST['web'],
	];

	$r['success']  = $Admin->saveById(CONFIG['idEmpresa'] , $_POST );
	*/
	$r['success']  = $Empresa->saveById(CONFIG['idEmpresa'] , ['email'=>$_POST['email']] );

}else{
	$r['success'] = false;
}

echo json_encode($r) ;