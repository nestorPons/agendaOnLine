<?php 
require_once "../../connect/conexion.php";
$conexion = conexion(true,false,true);

include '../core.php';
include 'view.php';
$fecha_inicio = $_GET['f'];
$datos_agenda = datosAgenda($_GET['f']);
$ids_existentes = json_decode(stripslashes($_GET['ids']));
agendas\view($datos_agenda,$fecha_inicio,$ids_existentes);