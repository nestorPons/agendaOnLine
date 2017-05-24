<?php 

//Compilando la hoja de estilos

function compilaLess($style_css,$style_less){
	global $conexion;
	//if (file_exists ( $style_css )) unlink ( $style_css);
	require_once __DIR__ . "/lessc.inc.php";

		$less = new lessc;
		$less->setFormatter("compressed");

	try {

		$sql = "SELECT * FROM config_css;";
		$result = mysqli_query($conexion, $sql);
		if ($config = mysqli_fetch_assoc($result)){		

			$less->arrPHP = $config;
			$less->checkedCompile($style_less,$style_css);
		
		}

	}catch (exception $e){

		echo "fatal error: " . $e->getMessage();
		
	}
}
