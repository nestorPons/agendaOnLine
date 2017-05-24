<?php 
if (strlen(session_id()) < 1)
	session_start ();
?>
<div class="menu menuServicios">
		<ul id = "lstSerMain" class="responsiveDesing_hidden">
			<?php
			foreach ($_SESSION['FAMILIAS'] as $valor){?>
				<a id="<?php echo $valor[0]?>"><?php echo $valor[1]?></a><?php	$capas = $valor[0];
			}?>
		</ul>
		
		 <!--uso attr name para el clone popup-->
		<select id="lstSerSelect" name= 'familia' class="responsiveDesing_show">
			<?php 
			foreach ($_SESSION['FAMILIAS'] as $valor){?>
				<option id="<?php echo $valor[0]?>" value='<?php echo $valor[0]?>' ><?php echo $valor[1]?></option><?php
			}?>
		</select>
</div>