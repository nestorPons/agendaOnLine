<div id="tablasEncabezado">
	<?php
	$sql = "SELECT Nombre FROM agendas";
	$result=mysqli_query($conexion,$sql);
	$nombreAgenda = mysqli_fetch_all($result);

	if (!$_SESSION['esMobil']){ ?>
		<table class = "tablas" >	
			<thead>
				<tr>
					<th class='num'>Hora</th>
					<?php
					for ($a=0;$a<CONFIG['NumAg'];$a++){
						?>
						<th class='aling-center'>
							<span id ="nombreAgenda<?php echo$a+1?>" class ="nombreAgenda" name="nombreAgenda[]" data-agenda="<?php echo $a ?>" >
								<?php echo empty($nombreAgenda[$a][0])?"Agenda $a":$nombreAgenda[$a][0]; ?>
							</span>
						</th>
						<?php
					}?>
				</tr>
			</thead>
		</table>
	<?php }else{
				?>
				<div class="tabcontrol" datar-role="tabcontrol" data-save-state=true>	
					<ul class="tabs">
						<?php
						for ($a=1;$a<=CONFIG['NumAg'];$a++){
							?>
							<li>
								<a href="">
								<?php
								echo empty($nombreAgenda[$a-1][0])?"Agenda $a":$nombreAgenda[$a-1][0]; 
								?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			} ?>
</div>