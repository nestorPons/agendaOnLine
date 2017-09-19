<?php
core\Security::session() ;
$fecha = $_GET['fecha'] ?? date('Y-m-d');

$id_fecha = str_replace('-','',$fecha);
$dia_semana = date('w',strtotime($fecha)) ;

$horarios = new models\Horarios ;
$lbl = new models\Lbl ;

$lbl->loadDates( $fecha ) ;
$arr_horas_ocupadas = array_column($lbl->data, 'tiempoTotal' , 'hora') ;
$horas = $horarios->hours($dia_semana);
$array_horas = $horas[$dia_semana]??false;

require_once URL_VIEWS . 'crearCita/horas.php' ;