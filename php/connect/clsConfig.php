<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/connect/clsConexion.php') ;
$confP = $conn->array('SELECT * FROM config ') ;

$conf = new Conexion( 'localhost','user','0Z8AHyYDKN0hUYik','aol_accesos' ) ;
$confG =  $conf->array( 'SELECT * FROM empresas WHERE Id = '.$confP['idEmpresa'] .' LIMIT 1' );
$row = array_merge($confG,$confP) ;


define('CONFIG', $row ) ;