<?php
if (strlen(session_id()) < 1) session_start ();

include $_SERVER['DOCUMENT_ROOT'].'/php/connect/conn.class.php' ; 

$conn = new connect\Conexion( 'bd_'. $_SESSION['bd'] );