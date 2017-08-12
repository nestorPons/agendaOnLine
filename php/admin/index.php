<?php
if (!isset($conn)){
	$fecha = Date('Y-m-d');
	require('../connect/config.controller.php');
	require('../libs/tools.php');
}

//Compilando la hoja de estilos
$url_empresa = "../../empresas/".$_SESSION['bd']."/";

$url_css = $url_empresa."estilos.css";
$url_less = $url_empresa."estilos.less";
require_once "../../css/compilaLess.php";
compilaLess($url_css,$url_less);

include 'core.php';



$url_font_main = "https://fonts.googleapis.com/css?family=" .
	str_replace(' ' ,'+' , CONFIG['font_main']) ."|" . 
	str_replace(' ' ,'+' , CONFIG['font_tile']) ; 
?>

<!DOCTYPE html>
<html lang="es"><head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<link href= "<?= $url_font_main ?>" rel="stylesheet">

<link rel='shortcut icon' href='../../img/favicon.ico' >
<link rel="stylesheet" href="../../css/jquery-ui.min.css">
<link rel="stylesheet" href="../../css/metro.css">
<link rel="stylesheet" href="../../fontello/css/iconos.css">
<link rel="stylesheet" href="../../empresas/<?= $_SESSION['bd']?>/estilos.css">

<script>
	document.festivos = <?=  json_encode (festivos())?>;
	document.horarios = <?=  json_encode(HORAS)?>;
	document.minTime = <?=  json_encode(CONFIG['MinTime'])?>;
	document.idUser = <?= $_SESSION['id_usuario']?>;
	document.margenDias  = <?= MARGEN_DIAS?> ; 
	document.mainStatus = <?= CONFIG['ShowRow']?> ;
</script>
<script  type="text/javascript" src="../../js/start.js"></script>
<title>agenda onLine</title>

</head><body data-empresa="<?=$_SESSION['bd']?>" >

	<?php include "../menus/menuAdmin.php"?>

	<div id='login' class='login'>
		<section id='main' class="capasPrincipales activa" ><?php include "main.php"?></section>
		<section id='usuarios' class="capasPrincipales" ></section>
		<section id='horarios' class="capasPrincipales" ></section>
		<section id='crearCita' class="capasPrincipales" ></section>
		<section id='servicios' class="capasPrincipales" ></section>
		<section id='familias' class="capasPrincipales" ></section>
		<section id='general' class="capasPrincipales" ></section>
		<section id='config' class="capasPrincipales" ></section>
		<section id='estilos' class="capasPrincipales" ></section>
		<section id='festivos' class="capasPrincipales" ></section>
		<section id='agendas' class="capasPrincipales" ></section>
		<section id='notas' class="capasPrincipales" ><?php// include "../../php/admin/notas.php"?></section>
	</div>
<div id="dialogs" class="popup-overlay"></div>

</body></html>
