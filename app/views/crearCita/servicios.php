<?php include URL_TEMPLATES . "menus/services.php"; ?>
<table class ='tablas-group  contenedorServicios' >
	<tbody>
		<?php
		foreach ($services as $service){
	
			include('rowServicios.php') ;
		}
		?>
	</tbody>
</table>
<button type="button" id="btnCancelar" class="btn-danger cancelar">Cancelar</button>
<button type="button" id="btnSiguiente" class="btn-success siguiente">Siguiente<i  class="icon-angle-right"></i></button>