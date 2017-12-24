<div class="menu menuServicios">
	<ul id = "lstSerMain" name= 'idFamilia' class="responsiveDesing_hidden">
		<?php
		foreach ($_SESSION['FAMILIAS'] as $family){
			$baja  =  ($family[3] == 0 ) ? '' : 'ocultar_baja' ;
			?>
			<a id="<?=$family[0]?>" class="<?=$baja?>"><?=$family[1]?></a>
			<?php	
			$capas = $family[0];			
		}?>
	</ul>
	
		<!--uso attr name para el clone popup-->
	<select id="lstSerSelect" name='idFamilia' class="responsiveDesing_show">
		<?php 
		$n = 0 ;
		
		foreach ($_SESSION['FAMILIAS'] as $family){
			$baja  =  ($family[3] == 0 ) ? '' : 'ocultar_baja' ;		
			if ($baja == '' && $n == 0){
				$n=1 ;
				$selected = 'selected' ;
			}else{
				$selected = '';
			}
			?>
			<option id="<?=$family[0]?>" value='<?=$family[0]?>' class="<?=$baja?>" <?=$selected?>> <?= $family[1]?> </option>
			<?php

		}?>
	</select>
</div>