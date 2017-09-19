<?php

if (!$_POST){exit(100);}

$id = $_POST['idCita']; 
$arr_cita['fecha'] = $_POST['fecha']; 
$arr_cita['hora'] = $_POST['hora']; 
$arr_cita['agenda'] = (int)$_POST['agenda']; 
$arr_cita['idUsuario'] = $_POST['idUsuario']; 
$arr_cita['obs'] = $_POST['obs']??''; 
$arrSer = $_POST['idServicios'] ?? null ;

$r['success'] = $Data->saveById($id , $arr_cita) ; 

if ($arrSer && $r['success']) { 
    
    $Cita->multi_query = true ;
        $Cita->deleteBy('idCita', $id ) ;
        foreach ($arrSer as $ser){
            $args = [
                'idCita' => $id , 
                'servicio' => $ser
            ]; 
           $Cita->saveById( 0, $args) ; 
        }
    $r['success'] =  $Cita->multi_query(); 
        
}