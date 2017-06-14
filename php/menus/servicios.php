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
			foreach ($_SESSION['FAMILIAS'] as $row){
				$baja  =  ($row[3] == 0 ) ? '' : 'ocultar_baja' ;		
				?>
				<option id="<?php echo $row[0]?>" value='<?php echo $row[0]?>' class="<?php echo$baja?>"><?php echo $row[1]?></option>
				<?php

			}?>
		</select>
</div>