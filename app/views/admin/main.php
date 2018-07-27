<div class="cabecera">
	<div class="cabecera-content">
		<?php 
			if (!$Device->isMovile){ require_once URL_TEMPLATES . "diasSemana.php"; }
		?>
	</div>
</div>
<div class="cuerpo <?php if($Device->isMovile) echo'esMovil'?>" >
	<div id="tablasEncabezado">
		<?php
		$agendas = $Agendas->get(); 

		if (TRUE/*!$Device->isMovile*/){ ?>
			<table class = "tablas" >	
				<thead>
					<tr>
						<?php
						for ($a=0;$a<$Agendas->count();$a++){
							$id = $agendas[$a][0];
							$name = $agendas[$a][1];
							?>
							<th class='aling-center'>
								<input tupy="text" id ="nombreagenda<?=$id?>" class ="nombreagenda" name="nombreagenda[]" data-agenda="<?=$id?>" 
								value=<?=$name?>>
								</input>
							</th>
							<?php
						}?>
					</tr>
				</thead>
			</table>
			<?php 
		}else{
			// Parte si es un mobil 
			?>
			<div id="tabcontrol" class="tabcontrol" datar-role="tabcontrol" data-on-tab-click="menuEsMovil" >	
				<ul class="tabs">
					<?php
					for ($a=0;$a<$Agendas->count();$a++){
						$id = $agendas[$a][0];
						$name = $agendas[$a][1];
						?>
						<li>
							<a href="" agenda=<?=$id?>><?=$name?></a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
		} ?>
	</div>
	<?php

	functions\view();
	?>
</div>	