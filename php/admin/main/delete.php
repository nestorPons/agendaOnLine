<?php
header('Content-Type: application/json');
require "../../connect/clsConexion.php";

$sql  = 'INSERT INTO del_data (IdCita,Agenda,IdUsuario,Fecha,Hora,Obs,UsuarioCogeCita) SELECT IdCita,Agenda,IdUsuario,Fecha,Hora,Obs,UsuarioCogeCita FROM data WHERE IdCita = '.$_GET['idCita'].'; ';
$sql .= 'INSERT INTO del_cita (Id,IdCita,Servicio) SELECT Id, IdCita, Servicio FROM cita WHERE IdCita = '.$_GET['idCita'].'; ';
$sql .= 'DELETE FROM data WHERE IdCita = '.$_GET['idCita'].'; ';
$sql .= 'DELETE FROM cita WHERE IdCita = '.$_GET['idCita'].'; ';

echo json_encode($conn->multi_query($sql));