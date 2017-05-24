<div class="cabecera" data-agendas= <?php echo CONFIG['NumAg']?>>
	<div class="cabecera-content">
		<?php 
			if (!$_SESSION['esMobil']){ require "../../php/menus/diasSemana.php"; }
			$nombreDp = 	'dpA';
			include "../../php/menus/datepicker.php";
		?>
	</div>
</div>
<div class="cuerpo"  data-estado-inactivas=<?php echo CONFIG['ShowRow']?> >
	<?php
	include '../../php/menus/tablasEncabezado.php';
	
	include 'agendas/view.php';
	$fecha_inicio = date('Y-m-d');
	
	agendas\view($datosAgenda,$fecha_inicio);
	
	?>
</div>	