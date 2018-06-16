<?php include URL_TEMPLATES . '/header.php'?>
	
	<script>
		document.festivos = <?=json_encode ($_SESSION['FESTIVOS']??'')?>;
		document.horarios = <?=json_encode($_SESSION['HORAS'])?>;
		
		document.minTime = <?=json_encode(CONFIG['minTime'])?>;
		document.idUser = <?=$_SESSION['id_usuario']?>;
		document.margenDias  = <?=MARGIN_DAYS?> ; 
	</script>
	<title>AgendaOnline zona admin</title>
</head>
	<body data-empresa="<?=CODE_EMPRESA?>" class="<?=$Device->type?>">

		<?php include URL_TEMPLATES . "menus/admin.php"?>

		<div id='login' class='login'>
			<section id='main' class="capasPrincipales activa" ><?php include URL_CONTROLLERS . "main.php"?></section>
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
			<section id='notas' class="capasPrincipales" ></section>
			<section id='history' class="capasPrincipales" ></section>
		</div>
		<div id="dialogs" class="popup-overlay"></div>
	</body>
</html>
