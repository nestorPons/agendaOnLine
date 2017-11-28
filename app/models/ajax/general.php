<?php 
$conf = new core\BaseClass('empresas' , 'aol_accesos') ;
$err = false; 
foreach($_POST as $key => $val){
	if(empty($val)) {
		$err = true; 
		break;
	}
}
if (!$err){
	$args = [
		'nombre'=>$_POST['nombre'] ,
		'email' => $_POST['email'] ,
		'tel' => $_POST['tel'] ,
		'nif' => $_POST['nif'] ,
		'dir' => $_POST['dir'] ,
		'poblacion' => $_POST['poblacion'] ,
		'pais' => $_POST['pais'],
		'cp' => $_POST['cp'],
		'web' => $_POST['web'],
	];

	$r['success']  = $conf->saveById(CONFIG['idEmpresa'] , $args );
}else{
    echo "DSA";
	$r['success'] = false;
}

echo json_encode($r) ;