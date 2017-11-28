<?php

if (!$_POST){exit(100);}

$idCita = $_POST['idCita']; 
$arr_cita['fecha'] = $_POST['fecha']; 
$arr_cita['hora'] = $_POST['hora']; 
$arr_cita['agenda'] = (int)$_POST['agenda']; 
$arr_cita['idUsuario'] = $_POST['idUsuario']??1; 
$arr_cita['obs'] = $_POST['obs']??''; 
$arr_cita['lastMod'] = date('Y-m-d H:i:s');

$arrSer = $_POST['idServicios'] ?? null ;

$r['success'] = $Data->saveById($idCita , $arr_cita) ; 

if ($arrSer && $r['success']) { 
    
    $Cita->multi_query = true ;
        $Cita->deleteBy('idCita', $idCita ) ;
        foreach ($arrSer as $ser){
            $args = [
                'idCita' => $idCita , 
                'servicio' => $ser
            ]; 
           $Cita->saveById( 0, $args) ; 
        }
    
    $r['success'] =  $Cita->multi_query(); 
        
}