<?php


$conn = new \core\Conexion('rtc_lebouquet',0); 
$arr = $conn->all("SELECT idCita, SUM(servicios.tiempo) as tiempo_servicios
FROM servicios JOIN cita ON cita.servicio = servicios.id
GROUP BY cita.idCita");

foreach($arr as $a){
    $sql = "UPDATE data SET tiempo_servicios = {$a[1]}  WHERE id = {$a[0]} AND tiempo_servicios=0"; 
echo($sql) .BR;
    $conn->query($sql);
}

die('OK');

/*
$cita1 = new \core\BaseClass('cita1','lebouquet_es');
$cita2 = new \core\BaseClass('cita2','lebouquet_es'); 
$data = new \core\BaseClass('data','rtc_lebouquet'); 
$cita = new \core\BaseClass('cita','rtc_lebouquet'); 
$servicios = new \core\BaseClass('servicios','rtc_lebouquet'); 
$cita1->sql ="SELECT * FROM cita1 WHERE Fecha >='2018-06-19'";
$cita2->sql ="SELECT * FROM cita2 WHERE Fecha >='2018-06-19'";
$arr1 = $cita1->query();
$arr2 = $cita2->query();


const HORAS =array(
    "07:00","07:15","07:30","07:45","08:00","08:15","08:30","08:45","09:00","09:15",
    "09:30","09:45","10:00","10:15","10:30","10:45","11:00","11:15","11:30","11:45",
    "12:00","12:15","12:30","12:45","13:00","13:15","13:30","13:45","14:00","14:15",
    "14:30","14:45","15:00","15:15","15:30","15:45","16:00","16:15","16:30","16:45",
    "17:00","17:15","17:30","17:45","18:00","18:15","18:30","18:45","19:00","19:15",
    "19:30","19:45","20:00","20:15","20:30","20:45");


$idCita = -1; 
$ser = '' ; 
$new = false; 
foreach($arr1 as $val){
    if($idCita != $val['IdCita']){
        $new = true; 
        $idCita = $val['IdCita'] ;
        
        $data->saveById(-1,[
            'agenda'=>1, 
            'idUsuario'=>$val['IdUsuario'], 
            'fecha'=>$val['Fecha'], 
            'hora'=>HORAS[$val['Hora']] ,
        ]); 
        $newIdCita = $data->getId(); 
    }
    if($new || $ser != $val['Servicio'] ){
        $new = false ;
        $ser = $val['Servicio'];
        $cita->saveById(-1,[
            'idCita'=>$newIdCita , 
            'servicio'=>$servicios->getBy('codigo', $val['Servicio'],'id')[0]
        ]);
    }
}
$idCita = -1; 
$ser = '' ; 
foreach($arr2 as $val){
    if($idCita != $val['IdCita']){
        $idCita = $val['IdCita'] ;
        $data->saveById(-1,[
            'agenda'=>2, 
            'idUsuario'=>$val['IdUsuario'], 
            'fecha'=>$val['Fecha'], 
            'hora'=>HORAS[$val['Hora']] ,
        ]); 
        $newIdCita = $data->getId();
    }
    if($idCita != $val['IdCita'] || $ser != $val['Servicio'] ){
        $cita->saveById(-1,[
            'idCita'=>$newIdCita , 
            'servicio'=>$servicios->getBy('codigo', $val['Servicio'],'id')[0]
            ]);
            $ser = $val['Servicio']; 
    }
}
*/