<?php

$fecha = $_POST['fecha'] ?? date('Y-m-d');

$ag = $_POST['agenda'] ?? 0;
$id_fecha = str_replace('-','',$fecha);
$dia_semana = date('w',strtotime($fecha)) ;

$Horarios = new models\Horarios ;
$Horarios2 =new models\Horarios ;

$lbl = new models\Lbl ;

$lbl->loadDates( $fecha ,$fecha , $ag ) ;
$arr_horas_ocupadas = array_column($lbl->data, 'tiempoTotal' , 'hora') ;
$Horarios->set_arr_busy($arr_horas_ocupadas); 
//print_r($lbl->data);

/*
foreach($arr_horas_ocupadas as $arr){
    echo $arr[0] . '>> >>' . $arr[1]; 
}
*/
$horas = $Horarios->hours($dia_semana,$_POST['agenda']);
$array_horas = $horas[$dia_semana][$ag]??false;

require_once URL_VIEWS_ADMIN . 'crearCita/horas.php' ;