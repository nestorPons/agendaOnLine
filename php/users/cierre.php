<?php 
include "connect/conexion.php";
$conexion = conexion();
registrarEvento(10,0,$_SESSION['id_usuario'],0);

session_unset();
session_destroy();
header ("location:../index.html");
?>