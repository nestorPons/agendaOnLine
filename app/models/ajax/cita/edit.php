<?php
$_POST = $Forms->sanitize($_POST);

$idCita = $_POST['idCita']; 
$arr_cita['fecha'] = $_POST['fecha']; 
$arr_cita['hora'] = $_POST['hora']; 
$arr_cita['agenda'] = (int)$_POST['agenda']; 
$arr_cita['idUsuario'] = $_POST['idUsuario']??err('usuario'); 
$arr_cita['obs'] = $_POST['obs']??''; 
$arr_cita['lastMod'] = date('Y-m-d H:i:s');

$arrSerPost = $_POST['servicios'] ?? null ;
$arrSerDb = $Cita->getBy('idCita',$idCita,'servicio');

if(!$r['success'] = $Data->saveById($idCita , $arr_cita)) $r['err'] = 'Save data'; 

if ($arrSerPost && $arrSerPost!=$arrSerDb && $r['success']) {
    
    $Cita->multi_query = true ;
        $Cita->deleteBy('idCita', $idCita ) ;
        foreach ($arrSerPost as $ser){

            $args = [
                'idCita' => $idCita , 
                'servicio' => $ser
            ]; 
        $Cita->saveById( 0, $args) ; 
        }
    
    if(!$r['success'] = $Cita->multi_query()) $r['err'] = 'Save cita'; 
}