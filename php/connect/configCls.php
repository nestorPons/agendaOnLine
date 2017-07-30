<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/connect/clsConexion.php') ;

$confP = $conn->assoc('SELECT * FROM config ') ;

$conf = new Conexion( 'localhost','user','0Z8AHyYDKN0hUYik','aol_accesos' ) ;
$confG =  $conf->assoc( 'SELECT * FROM empresas WHERE Id = '.$confP['idEmpresa'] .' LIMIT 1' );
$row = array_merge($confG,$confP) ;

define('CONFIG', $row ) ;