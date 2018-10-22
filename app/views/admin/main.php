<div class="cabecera">
	<div class="cabecera-content">
		<?php 
		if (!$Device->isMobile()){ require_once URL_TEMPLATES . "diasSemana.php"; }
		?>
	</div>
</div>
<div class="cuerpo <?php if($Device->isMobile()) echo'esMovil'?>" >
	<div id="tablasEncabezado">
		<?php
		$agendas = $Agendas->get(); 
		?>
		<table class = "tablas" >	
			<thead>
				<tr>
					<?php
					for ($a=0;$a<$Agendas->count();$a++){
						$id = $agendas[$a][0];
						$name = $agendas[$a][1];
						?>
						<th class='aling-center'>
							<input type="text" id ="nombreagenda<?=$id?>" class ="nombreagenda" name="nombreagenda[]" data-agenda="<?=$id?>" 
							value=<?=$name?>>
							</input>
						</th>
						<?php
					}?>
				</tr>
			</thead>
		</table>
	
	</div>
	<?php
	functions\view();
	?>
</div>	