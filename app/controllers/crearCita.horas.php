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


//AKI :: tengo una variable global HORAS que tiene esta informacion
$horas = $Horarios->hours($dia_semana,$_POST['agenda']);
$array_horas = $horas[$dia_semana]??false;

require_once URL_VIEWS_ADMIN . 'crearCita/horas.php' ;