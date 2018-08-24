<?php 

//Compilando la hoja de estilos
// los css fijos 
compilaLess(URL_EMPRESA."style.css",URL_EMPRESA."style.less");
compilaLess(URL_CSS."main.css",URL_CSS."main.less", false);

// css variables login

if ($controller == 'login') compilaLess(URL_CSS."login.css",URL_CSS."login.less");

function compilaLess($style_css,$style_less){
	global $Empresa ; 
	
	include_once URL_CLASS . "lessc.inc.php";
	$less = new lessc;
	
//	if (file_exists($style_css )) unlink ( $style_css);

		$less->setFormatter("compressed");

	try {

		//if ($config = $conn->assoc("SELECT * FROM config_css"))
		$less->arrPHP = $Empresa->conf_css();
			
		$less->checkedCompile($style_less,$style_css);

	}catch (Exception $e){

		echo "fatal error: " . $e->getMessage();
		
	}
}
