<?php
$result= mysqli_query($conexion,"SELECT * FROM familias WHERE Mostrar=1");	
$servicios = mysqli_fetch_all($result,MYSQLI_NUM);
$num = mysqli_num_rows($result);
?>
<div id="mnuFamilias" class="menu " >
	<ul class="responsiveDesing_hidden">
		<?php
			for($i=0;$i<$num;$i++){?>
			<a id="<?php echo$servicios[$i][0]?>"><?php echo $servicios[$i][1]?></a><?php
			}?>
	</ul>
	<div class="responsiveDesing_show">
		<select id="seleccion" >
			<?php
			for($i=0;$i<$num;$i++){?>
				<option id="<?php echo $servicios[$i][0]?>" value='<?php echo $servicios[$i][0]?>'><?php echo$servicios[$i][1]?></option>
				<?php
			}?>
		</select>
	</div>
</div>
<?php
for($i=1;$i<=$num+1;$i++){
	?>
	<div  id="capa<?php echo $i?>" class="contenedorTablas <?php if($i>1)echo"hidden"?>" >
		<table class="aling-center">
			<?php
				$sql = "SELECT * FROM articulos WHERE IdFamilia = $i AND Baja = 0 ORDER BY Descripcion";
				$resultArt= mysqli_query($conexion,$sql);
				while($rowArt=mysqli_fetch_array($resultArt)){
				?>
				<tr>
					<td>
						<label>
							<input type="checkbox" name="servicios[]" id ="<?php echo $rowArt["Codigo"]?>"  
							value="<?php echo$rowArt["Id"]?>" data-time="<?php echo $rowArt["Tiempo"]?>"
							data-descripcion="<?php echo$rowArt["Descripcion"]?>">
							<?php echo " ".$rowArt["Descripcion"]." (".$rowArt["Tiempo"]."min.)"?>
						</label>
					</td>
				</tr>
				<?php
				}?>
		</table>
	</div>
	<?php
}?>