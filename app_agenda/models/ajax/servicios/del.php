<?php header('Content-Type: application/json');
$Servicios = new core\BaseClass('servicios');
$r['success'] = $Servicios->saveById($_POST['id'] , array('baja' => 1 ));
echo json_encode($r) ;
