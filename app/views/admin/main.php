<div class="cabecera">
	<div class="cabecera-content">
		<?php 
			if (!$Device->isMovile){ require_once URL_TEMPLATES . "diasSemana.php"; }
			include_once URL_TEMPLATES . "datepicker.php";
		?>
	</div>
</div>
<div class="cuerpo <?php if($Device->isMovile) echo'esMovil'?>" >
	<?php
	include_once URL_TEMPLATES . 'agenda.head.php';
	functions\view();
	?>
</div>	