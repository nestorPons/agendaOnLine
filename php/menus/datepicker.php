<div class = "contenedorDatepicker">
	<div class="iconClass-container">	
		<i data-action="-1" class="icon-left-open idDateAction" data-disabled=false></i>
		<i data-action="1" class="icon-right-open idDateAction" data-disabled=false></i>
		<input class='datepicker date' 
			type='text' 
			id='<?= $nombreDp?>' 
			value='<?= formatofecha($fecha)??Date('Y-m-d')?>'
			data-festivos-show=true data-min-date=<?= $minDate??null;?>>
	</div>               
</div>