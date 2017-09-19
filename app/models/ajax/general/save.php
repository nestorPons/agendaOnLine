<?php
$conf = new core\BaseClass('empresas' , 'aol_accesos') ;

$args = [
	'email' => (!empty($_POST['email']))?trim($_POST['email']):"" ,
	'tel' => (!empty($_POST['tel']))?trim($_POST['tel']):"" ,
	'nif' => $_POST['nif']??"" ,
	'dir' => $_POST['dir']??"" ,
	'poblacion' => $_POST['poblacion']??"" ,
	'pais' => $_POST['pais']??"" ,
	'cp' => $_POST['cp']??"" ,
	'web' => $_POST['web']??"" ,
];

$r  = $conf->saveById(CONFIG['idEmpresa'] , $args );

echo json_encode($r) ;