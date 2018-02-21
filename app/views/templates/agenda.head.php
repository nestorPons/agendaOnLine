<div id="tablasEncabezado">
	<?php

	$nombreagenda = $conn->all("SELECT nombre FROM agendas");

	if (!$Device->isMovile){ ?>
		<table class = "tablas" >	
			<thead>
				<tr>
					<th class='num'>hora</th>
					<?php
					for ($a=0;$a<CONFIG['num_ag'];$a++){
						?>
						<th class='aling-center'>
							<span id ="nombreagenda<?php echo$a+1?>" class ="nombreagenda" name="nombreagenda[]" data-agenda="<?php echo $a ?>" >
								<?php echo empty($nombreagenda[$a][0])?"agenda $a":$nombreagenda[$a][0]; ?>
							</span>
						</th>
						<?php
					}?>
				</tr>
			</thead>
		</table>
		<?php 
	}else{
		// PArte si es un mobil 
		?>
		<div id="tabcontrol" class="tabcontrol" datar-role="tabcontrol" data-save-state=true data-on-tab-click="menuEsMovil" >	
			<ul class="tabs">
				<?php
				for ($a=1;$a<=CONFIG['num_ag'];$a++){
					?>
					<li agenda=<?=$a?> value=<?=$a?>>
						<a href="" agenda=<?=$a?>>
						<?php
						echo empty($nombreagenda[$a-1][0])?"agenda $a":$nombreagenda[$a-1][0]; 
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