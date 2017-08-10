<?php session_start(); ?>
<div  class="dialog" id="dlgEditCita">
		<h1>Editando...</h1>
		<hr>
		<div class="template" >
			<span class="icon-cancel-circled"></span>
			<span class='codigo'></span>
			<span class='descripcion'></span>
		</div>
		<div class="iconClass-container icon-left">
			<input type="text" class="txt" id="id" readonly>
			<span class="iconClass-inside  icon-angle-right"></span>
		</div>
		<div class="iconClass-container icon-left">
			<input type="text" class="txt" id="nombre" >
			<span class="iconClass-inside  icon-user-1"></span>
		</div>
		<div class="iconClass-container icon-left">
			<input type="date" class="txt" id="fecha"  >
			<span class="iconClass-inside  icon-calendar"></span>
		</div>
		<div class="iconClass-container icon-left">
			<input type="time" class="txt" id="hora"  >
			<span class="iconClass-inside  icon-clock"></span>
		</div>
		<div id= "codigos"  class="iconClass-container icon-left lst"></div>
		<div id= "newCodigo"  class="iconClass-container icon-left">
			<select name="" id="lstServ">
				<option value='' disabled selected hidden>Añadir servicios</option>
				<?php 
				foreach($_SESSION['SERVICIOS'] as $row){
					?>
					<option value="<?php echo $row[0] ?>" codigo ="<?php echo $row[1] ?>" tiempo="<?php echo $row[4]?>"> <?php echo $row[2] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		
		<div id="lstServicios" class="iconClass-container icon-left">
			<div class="iconClass-container icon-left">
				<input type="text" class="txt" id="obs" >
				<span class="iconClass-inside  icon-note"></span>
			</div>
		</div>

		<button type="button" class="btn-danger btnLoad eliminar" id="btnEliminarCita" data-value="Eliminar"></button>
		<button type="button" class="btn-success btnLoad aceptar" id="btnGuardarCita" data-value="Guardar"></button>
	</div>
</div>