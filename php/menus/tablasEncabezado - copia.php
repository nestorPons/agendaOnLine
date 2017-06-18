<div id="tablasEncabezado">
	<?php
	$sql = "SELECT Nombre FROM agendas";
	$result=mysqli_query($conexion,$sql);
	$nombreAgenda = mysqli_fetch_all($result);

	if (!$_SESSION['esMobil']){ ?>
		<table class = "tablas encabezado" >	
			<tr>
				<td class='num'>Hora</td>
				<?php
				for ($a=0;$a<CONFIG['NumAg'];$a++){
					?>
					<td class='aling-center'>
						<span id ="nombreAgenda<?php echo$a+1?>" class ="nombreAgenda" name="nombreAgenda[]" data-agenda="<?php echo $a ?>" >
							<?php echo empty($nombreAgenda[$a][0])?"Agenda $a":$nombreAgenda[$a][0]; ?>
						</span>
					</td>
					<?php
				}?>
			</tr>
		</table>
	<?php }else{?>
	<div class="iconClass-container">
		<select id="selectTablasEncabezado"> 
			<?php
			for ($a=0;$a<CONFIG['NumAg'];$a++){
				?>
				<option value='<?php echo $a+1?>' ><?php echo empty($nombreAgenda[$a-1][0])?"Agenda $a":$nombreAgenda[$a-1][0]; ?></option>
				<?php
			}
			?>
		</select>
	</div>
<?php } ?>
</div>