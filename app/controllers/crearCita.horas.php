<?php

$fecha = $_POST['fecha'] ?? date('Y-m-d');

$ag = isset($_POST['agenda'])?$_POST['agenda']:0;
$id_fecha = str_replace('-','',$fecha);
$dia_semana = date('w',strtotime($fecha)) ;

$Horarios = new models\Horarios ;
$Horarios2 =new models\Horarios ;


$lbl = new models\Lbl ;

$lbl->loadDates( $fecha ,$fecha , $ag ) ;

$arr_horas_ocupadas = $Horarios->set_arr_busy(array_column($lbl->data, 'tiempoTotal' , 'hora')); 

$horas = $Horarios->hours($dia_semana,$_POST['agenda']);
$array_horas = $horas[$dia_semana][$ag]??false;

require_once URL_VIEWS_ADMIN . 'crearCita/horas.php' ;