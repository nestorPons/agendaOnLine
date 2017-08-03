<div class="cabecera">
	<div class="cabecera-content">
		<?php 
			if (!$_SESSION['esMobil']){ require "../menus/diasSemana.php"; }
			$nombreDp = 'dpA';
			include "../menus/datepicker.php";
		?>
	</div>
</div>
<div class="cuerpo" >
	<?php
	include '../menus/tablasEncabezado.php';
	
	include 'main/clsLbl.php';
	include 'main/view.php';
	
	view($datosAgenda,$fecha);
		
	?>
</div>	