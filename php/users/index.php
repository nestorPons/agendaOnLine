<?php
require('../../php/connectconnect/conexion.php');
$conexion = conexion(true,false,true);
include ('../../php/admin/consulta.php');

//Compilando la hoja de estilos 
require_once __DIR__ . "css/lessc.inc.php";
$less = new lessc;
$less->setFormatter("compressed");
try {
	$less->checkedCompile("../../css/style.less", "../../css/style.css");
}catch (exception $e){
	echo "fatal error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es"><head> 
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel='shortcut icon' href='../../img/favicon.ico' >
<link rel="stylesheet" href="../../css/jquery-ui.min.css">

<link rel="stylesheet"  type="text/css" href="../../css/estilos.css">
<script  type="text/javascript" src="../../js/start.js" async ></script>
<script>
	document.festivos = <?php echo  json_encode ($data['festivos'])?>;
	document.horarios = <?php echo  json_encode($data['horarios'])?>;
	document.agenda = <?php echo  json_encode ($data['agenda'])?>;
</script>
<title>Menu agenda general</title>
</head>
<body id="user" data-iduser= <?php echo $_SESSION['id_usuario']?> 
	data-empresa = "<?php echo CONFIG['Nombre']?>"
	data-mintime = <?php echo CONFIG['MinTime']?>>
<?php include '../../php/users/menu.php'?>
<div id="login" class="login">	
	<div class="tile-container" id="contenedorMenuPrincipal">
		<section id="crearCita" name="tile" class="tile bg-lime  c-white" data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<span class="icon icon-edit"></span>
					<span class="tile-label">Coja su cita</span>
				</div>
				<div id="" class="contenido">
					<?php include '../../php/users/cogerCita/index.php'?>
				</div>
			</div>
		</section>
		<section id="config"  name="tile" class="tile bg-c4  c-white" data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<span class="icon icon-user-1"></span>
					<span class="tile-label">Mis datos</span>
				</div> 	
				<div class="contenido">
					<?php include '../../php/users/usuario/index.php'?>
				</div>
			</div>
		</section>
		<section id="historial" class="tile-wide bg-c3  c-white"  name="tile" data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<h3><span id='mensajeHistorial'></span></h3>
					<span class="icon icon-calendar"></span>
					<span id="lblHis" class="tile-badge"></span>
					<span class="tile-label">Citas</span>
				</div>
				<div class="contenido">
					<h1 class="margin0">Historial</h1>
						<?php include '../../php/users/historial/index.php'?>
					<input type="button" class="btn-danger cerrar" name="cancelar" value="Cerrar"> 
				</div>
			</div>
		</section>
		<section id="eliminar" class="tile-small bg-red  c-white"  name="tile" data-role="tile">
			<div class="tile-content">
				<span  class="icon icon-user-times" data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" 
					data-hint="Eliminar|Pusar para eliminar el usuario">
				</span>
			</div>
		</section>
	</div>
</div>
	<section class="about">
		<div id="fb-root"></div>
		<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" 
			data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true"></div>
	</section>
	<div id="mns" class="popup-overlay"></body></html>
</body></html>