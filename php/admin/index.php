<?php
if (!isset($conn)){
	$fecha = Date('Y-m-d');
	require('../connect/clsConfig.php');
	require('../connect/tools.php');
}

//Compilando la hoja de estilos
$url_empresa = "../../empresas/".$_SESSION['bd']."/";
$url_css = $url_empresa."estilos.css";
$url_less = $url_empresa."estilos.less";
require_once "../../css/compilaLess.php";
compilaLess($url_css,$url_less);

include 'core.php';

?>
<!DOCTYPE html>
<html lang="es"><head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

<link rel='shortcut icon' href='../../img/favicon.ico' >
<link rel="stylesheet" href="../../css/jquery-ui.min.css">
<link rel="stylesheet" href="../../css/metro.css">
<link rel="stylesheet" href="../../fontello/css/iconos.css">
<link rel="stylesheet" href="../../empresas/<?php echo $_SESSION['bd']?>/estilos.css">

<script  type="text/javascript" src="../../js/start.js"></script>
<script>
	document.festivos = <?php echo  json_encode (festivos())?>;
	document.horarios = <?php echo  json_encode(HORAS)?>;
	document.minTime = <?php echo  json_encode(CONFIG['MinTime'])?>;
	document.idUser = <?php echo $_SESSION['id_usuario']?>;
	document.margenDias  = <?php echo MARGEN_DIAS?> ; 
</script>
<title>Agenda onLine</title>

</head><body data-empresa="<?php echo CONFIG['Nombre']?>" >
	<?php include "../menus/menuAdmin.php"?>

	<div id='login' class='login'>
		<section id='main' class="capasPrincipales activa"><?php include "../../php/admin/main.php"?></section>
		<section id='usuarios' class="capasPrincipales" data-url="../../php/admin/usuarios/index.php"></section>
		<section id='horarios' class="capasPrincipales" data-url="../../php/admin/horarios/index.php"></section>
		<section id='crearCita' class="capasPrincipales" data-url="../../php/admin/crearCita/index.php"></section>
		<section id='servicios' class="capasPrincipales" data-url="../../php/admin/servicios/index.php"></section>
		<section id='familias' class="capasPrincipales" data-url="../../php/admin/familias/index.php"></section>
		<section id='general' class="capasPrincipales" data-url= "../../php/admin/general/index.php"></section>
		<section id='config' class="capasPrincipales" data-url= "../../php/admin/config/index.php"></section>
		<section id='agendas' class="capasPrincipales" data-url= "agendas.php"></section>
		<section id='festivos' class="capasPrincipales" ><?php  //include "../../php/admin/festivos/index.php"?></section>
		<section id='notas' class="capasPrincipales" ><?php// include "../../php/admin/notas.php"?></section>
	</div>
<div id="dialogs" class="popup-overlay"></div>

</body></html>
