<h1>Festivos</h1>
<form id="frmNuevo">
	<table class="tablas">
		<tr id="nuevo">
			<th  class="aling-left"><input type="text" name='nombre[]' placeholder="Añadir dia festivo"
				data-role="popover" data-popover-position="bottom" data-popover-text="Error falta el nombre" 
				data-popover-background="bg-red"  data-popover-color="fg-white">
			</th>
			<th>
				<input  type="text"  class="datepicker" id="dpFestivos"  name="fecha" data-festivos-show="true" 
				data-role="popover" data-popover-position="bottom" data-popover-text="Error falta la fecha" 
				data-popover-background="bg-red" data-popover-background="bg-green" data-popover-color="fg-white">
			</th>
		</tr>
	</table> 		
</form>
<table class="tablas  encabezado">
	<tr>
		<td>Opc</td>
		<td >Nombre:</td>
		<td>Fecha:</td>
	</tr>
</table>
<table id="tblFestivos" class="tablas">
	<?php
	$sql="SELECT * FROM festivos ORDER BY ID ASC";
	$result = mysqli_query($conexion,$sql);
	while($festivos= mysqli_fetch_array($result)){
		?>
		<tr id="<?php echo$festivos['Id']?>">
			<td><a name="eliminar[]"  class= "icon-cancel c5 x6"></a></td>
			<td  class="aling-left"><span name='nombre[]'><?php echo$festivos['Nombre']?></span></td>
			<td> <span  name='mes[]' ><?php echo formatoFecha($festivos['Fecha'],'/')?></span></td>
		</tr>
		<?php
	}  
	?>
</table>