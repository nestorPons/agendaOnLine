<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/connect/conn.controller.php') ;

$confP = $conn->assoc('SELECT * FROM config ') ;
$configCSS = $conn->assoc('SELECT * FROM config_css ') ;

$conf = new connect\Conexion( 'aol_accesos' ) ;
$confG =  $conf->assoc( 'SELECT * FROM empresas WHERE Id = '.$confP['idEmpresa'] .' LIMIT 1' );
$row = array_merge($confG,$confP,$configCSS) ;

define('CONFIG', $row ) ;