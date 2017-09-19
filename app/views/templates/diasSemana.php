<div class="menu diassemana">
	<?php 
	if (!$_SESSION['esMobil']){
		?>
		<ul id="mainLstDiasSemana" class="lstMenu">
			<a id="mainMenu1" data-value=1>Lun</a>
			<a id="mainMenu2" data-value=2>Mar</a>
			<a id="mainMenu3" data-value=3>Mie</a>
			<a id="mainMenu4" data-value=4>Jue</a>
			<a id="mainMenu5" data-value=5>Vie</a>
			<a id="mainMenu6" data-value=6>Sab</a>
			<a id="mainMenu7" data-value=7>Dom</a>
		</ul>
		<?php
	}else{
		?>
		<select id='lstDiasSemana' class='lstMenu'>
			<option value=1>Lunes</option>
			<option value=2>Martes</option>
			<option value=3>Miércoles</option>
			<option value=4>Jueves</option>
			<option value=5>Viernes</option>
			<option value=6>Sábado</option>
			<option value=7>Domingo</option>
		</select>	
		<?php
	}
	?>
</div>
