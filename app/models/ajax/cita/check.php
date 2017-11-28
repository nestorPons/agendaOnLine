<?php
//check cita
$citasBd = array();
$citasView = $_POST['citas'] ?? null;

$result = $Data->getBy('fecha' , $_POST['fecha'] , 'id, lastMod');

foreach($result as $value){
    $citasBd[$value['id']] = $value['lastMod'];
}
//AKI :: comparando arrays para refrescar el main 
var_dump($citasView);
echo "************";
var_dump($citasBd);
echo "************";
//$result = compareArray($citasBd , $citasView);

var_dump($result);
/*
foreach ($views as $key => $view){
    
    $dbs[]

    $ids[] = $value['ids'];
    $lastMods = $value['lastMod'];
}

var_dump($ids);


if ($result['val']>=1){
    $r['del'] = $result['comp2'];
}

if ($result['val']>=2){

    foreach($result['comp1'] as $value){
        $r['add'] = $Lbl->getById($value);
    }

}
// check services 
*/