<h1>Configuracion Agendas</h1>
<h2>Seleccione las agendas que quiere que vean los clientes:</h2>
<form id="frmAg" class="">
<?php 
	for ($i=1;$i<=6;$i++){
		$b = $i+5;
		$disabled = $i<=CONFIG['NumAg']?"":"disabled";
		$disabledb = $b<=CONFIG['NumAg']?"":"disabled";
		$sql = "SELECT * FROM agendas WHERE Id = $i";
		$row=mysqli_fetch_assoc(mysqli_query($conexion,$sql));
		$checked = $row['Mostrar']==0?"":"checked";
		$nom = $disabled=="disabled"?"":$row['Nombre'];
		$sql = "SELECT * FROM agendas WHERE Id = $b";
		$row=mysqli_fetch_assoc(mysqli_query($conexion,$sql));
		$checkedb = $row['Mostrar']==0?"":"checked";
		$nomb = $disabledb=="disabled"?"":$row['Nombre'];
		?>
		<label id="agenda<?php echo$i?>">
			<input id="a<?php echo$i?>" type="checkbox" name="chck[]" value='<?php echo$i?>' <?php echo$disabled." ".$checked?>>
			<input id = "txt<?php echo$i?>" type="text" name="nombre[]" placeholder="Agenda<?php echo$i?>"
				value="<?php echo$nom?>" <?php echo$disabled?>>
		</label>
		<?php
	}?>
</form>
<div id="popupAgendas">
<div class="content-popup hidden">
	<div class="close"><a href="#" class="icon-cancel-circled2 x6 close"></a></div>
		<h1>Editando servicios</h1>
		<form  id='mensaje'>
			¿Desea contratar más agendas?
			<p class="submit">
				<input type="button" id="cancelar" value="Cancelar" class="btn-danger">
				<input type="submit" id="aceptar" value="Aceptar" class="btn-success">
			</p>
		</form>
	</div>
</div>
