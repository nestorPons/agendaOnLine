<?php include "menus/diasSemana.php"?>
<form id="frmNotas">
	<table class = "contenedorDatepicker">	
		<td><i name ="desplazarFecha" data-action="-1" class="icon-left-open x6" data-disabled=true></i></td>
		<td><input name="datepicker" class='datepicker' type='text' id='dpA' data-festivos-show=true data-min-date="null"></td>
		<td><i name="desplazarFecha" data-action="1" class="icon-right-open x6" data-disabled=true></i></td>
	</table>               
	<textarea id='txtNotas' class="notas" name='notas' ROWS=5></textarea>
	<p class="submit">
		<button type="button" class="btn-danger btnLoad" id="btnEliminar" data-value="Eliminar"></button>
		<button type="submit" class="btn-success btnLoad" id="btnAceptar" data-value="Guardar"></button>	
	</p>
</form>