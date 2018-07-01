<?php include URL_MENUS . "servicios.php"; ?>
<table class ='tablas-group  contenedorServicios' > 
	<tbody>
		<?php
		foreach ($_SESSION['SERVICIOS'] as $ser){
	
			include('rowServicios.php') ;
		}
		?>
	</tbody>
</table>
	<button type="button" id="btnSiguiente" class="btn-success siguiente">Siguiente<i  class="icon-angle-right"></i></button>
	<button type="button" id="btnCancelar" class="btn-danger cancelar">Cancelar</button>
<br>