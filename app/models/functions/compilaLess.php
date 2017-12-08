<?php 

//Compilando la hoja de estilos

$url_css = URL_EMPRESA . "style.css";
$url_less = URL_EMPRESA . "style.less";

require_once( URL_FUNCTIONS . 'compilaLess.php') ; 
compilaLess($url_css,$url_less);


$url_css = URL_CSS . "main.css";
$url_less = URL_CSS . "main.less";

compilaLess($url_css,$url_less);


function compilaLess($style_css,$style_less){
	global $conn ; 
	
	include_once URL_CLASS . "lessc.inc.php";
	$less = new lessc;
	
	if (file_exists ( $style_css )) unlink ( $style_css);

		$less->setFormatter("compressed");

	try {

		if ($config = $conn->assoc("SELECT * FROM config_css"))
			$less->arrPHP = $config;
			

		$less->checkedCompile($style_less,$style_css);

	}catch (Exception $e){

		echo "fatal error: " . $e->getMessage();
		
	}
}
