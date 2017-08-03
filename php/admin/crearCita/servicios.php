<?php include $_SERVER['DOCUMENT_ROOT']."/php/menus/servicios.php"; ?>
<table class ='tablas-group  contenedorServicios' >
	<tbody>
		<?php

		foreach ($_SESSION['SERVICIOS'] as $row){
		
			// 0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
			include('rowServicios.php') ;
		}
		?>
	</tbody>
</table>
<button type="button" id="btnCancelar" class="btn-danger cancelar">Cancelar</button>
<button type="button" id="btnSiguiente" class="btn-success siguiente">Siguiente<i  class="icon-angle-right"></i></button>