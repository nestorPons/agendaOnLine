<?php
//check cita
$dataPost = $_POST['citas'] ?? false;

$data = $Data->getBy('fecha' , $_POST['fecha']);
//Arreglo primer array
foreach($data as $value){

    $id = $value['id'];
    $dataDb[$id] = $value;
    //Busco añadidos 
    if (!$dataPost||!in_array($id, array_column($dataPost, 'id')))
        $r['add'][] = _getCita($id, $value);
} 

if ($dataPost){
    //Arreglo segundo array
    foreach($dataPost as $value){
        $id = $value['id'];
        //busco borrados
        if (isset($dataDb[$id])){
            // Busco editados 
            if($value['lastMod'] != $dataDb[$id]['lastMod'])
                $r['edit'][] =  _getCita($id,$dataDb[$id]);
        } else {
            $r['del'][] = $id;
        } 
    } 
}

function _getCita($id,$data){
    global $Cita, $Serv, $Users;
    $cita = $Cita->getBy('idCita', $id );
    $data['nombre'] = $Users->getById((int)$data['idUsuario'], 'nombre');

    foreach($cita as $key => $val){
        $serv = $Serv->getById($val['servicio']);
        $mCita[] = array_merge($val,$serv); 
    }
    
    return [$data,$mCita];   
 }