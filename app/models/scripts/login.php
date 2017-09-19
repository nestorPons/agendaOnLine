<?php
$url_empresa = URL_EMPRESAS. $_GET['empresa']."/";

$url_logo_ico = file_exists($url_empresa."logo.ico")?$url_empresa."logo.png":"../img/logo.ico";
$url_logo_img = file_exists($url_empresa."logo.png")?$url_empresa."logo.png":"../img/logo.png";
$nombre_empresa =  ucwords(strtolower($_GET['empresa']),'_');
$nombre_empresa = str_replace("_"," ",$nombre_empresa);
$nombre_empresa = str_replace("/","",$nombre_empresa);

function srcLogo(){
	$url = URL_EMPRESAS . $_GET['empresa']."/logo.png" ;
	return file_exists($url) ? '/empresas/' . $_GET['empresa']."/logo.png" :  "/img/logo.png" ;
}

function backgroundImage() {
	$url = URL_EMPRESAS . $_GET['empresa']."/background.jpg" ;
	return file_exists($url) ?'/empresas/' . $_GET['empresa']."/background.jpg": "/img/background.jpg" ;
}
