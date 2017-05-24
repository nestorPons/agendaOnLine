<div class = "contenedorDatepicker">
	<div class="iconClass-container">	
		<i name ="desplazarFecha" data-action="-1" class="icon-left-open x6" data-disabled=false></i>
		<i name="desplazarFecha" data-action="1" class="icon-right-open x6" data-disabled=false></i>
		<input class='datepicker date' 
			type='text' 
			id='<?php echo $nombreDp?>' 
			value='<?php echo Date('d/m/Y')?>'
			data-festivos-show=true data-min-date=<?php echo $minDate??null;?>>
	</div>               
</div>