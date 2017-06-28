<div class="cabecera" data-agendas= <?php echo CONFIG['NumAg']?>>
	<div class="cabecera-content">
		<?php 
			if (!$_SESSION['esMobil']){ require "../menus/diasSemana.php"; }
			$nombreDp = 'dpA';
			include "../menus/datepicker.php";
		?>
	</div>
</div>
<div class="cuerpo"  data-estado-inactivas=<?php echo CONFIG['ShowRow']?> >
	<?php
	include '../menus/tablasEncabezado.php';
	
	include 'agendas/view.php';
	$fecha_inicio = date('Y-m-d');
	
	agendas\view($datosAgenda,$fecha_inicio);
	
	include 'agendas/clsLbl.php';
	$new =  new Lbl($datosAgenda) ;
	
	?>
</div>	