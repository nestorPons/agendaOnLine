<?php
header('Content-Type: application/json');
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/conn.controller.php');

$id = $_POST['idCita'];
$a = $_POST['agenda'] ; 
$f = $_POST['fecha'] ; 
$h = $_POST['hora'] ; 
$user = $_POST['idUsuario'];
$note = $_POST['obs'];
$ser = $_POST['codigos'] ;

$sql = "UPDATE data SET IdUsuario='$user', Obs='$note' , Agenda = $a , Fecha ='$f' , Hora = '$h' WHERE IdCita=$id ; ";
$sql .=	"DELETE FROM cita WHERE idCita = $id ;" ;
foreach ( $ser as $key => $val ) {
	$sql .= "INSERT INTO cita ( IdCita, Servicio ) VALUES ( $id , $val );";
}
echo json_encode($conn->multi_query($sql));
