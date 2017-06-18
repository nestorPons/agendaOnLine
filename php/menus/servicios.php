<?php 
if (strlen(session_id()) < 1)
	session_start ();
?>
<div class="menu menuServicios">
		<ul id = "lstSerMain" class="responsiveDesing_hidden">
			<?php
			foreach ($_SESSION['FAMILIAS'] as $row){
				$baja  =  ($row[3] == 0 ) ? '' : 'ocultar_baja' ;
				?>
				<a id="<?php echo $row[0]?>" class="<?php echo$baja?>"><?php echo $row[1]?></a>
				<?php	
				$capas = $row[0];
				
			}?>
		</ul>
		
		 <!--uso attr name para el clone popup-->
		<select id="lstSerSelect" name= 'familia' class="responsiveDesing_show">
			<?php 
			$n = 0 ;
			
			foreach ($_SESSION['FAMILIAS'] as $row){
				$baja  =  ($row[3] == 0 ) ? '' : 'ocultar_baja' ;		
				if ($baja == '' && $n == 0){
					$n=1 ;
					$selected = 'selected' ;
				}else{
					$selected = '';
				}
				?>
				<option id="<?php echo $row[0]?>" value='<?php echo $row[0]?>' class="<?php echo$baja?>" <?php echo $selected?>> <?php echo $row[1]?> </option>
				<?php

			}?>
		</select>
</div>