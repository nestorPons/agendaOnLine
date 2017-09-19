<div class="cabecera">
	<div class="cabecera-content">
		<?php 
			if (!$_SESSION['esMobil']){ require_once URL_TEMPLATES . "diasSemana.php"; }
			include_once URL_TEMPLATES . "datepicker.php";
		?>
	</div>
</div>
<div class="cuerpo" >
	<?php
	include_once URL_TEMPLATES . 'agenda.head.php';
	
	functions\view();
	?>
</div>	