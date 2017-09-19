<div id="tablasEncabezado">
	<?php
	
	$nombreagenda = $conn->all("SELECT nombre FROM agendas");

	if (!$_SESSION['esMobil']){ ?>
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
			?>
		<div class="tabcontrol" datar-role="tabcontrol" data-save-state=true>	
			<ul class="tabs">
				<?php
				for ($a=1;$a<=CONFIG['num_ag'];$a++){
					?>
					<li>
						<a href="">
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