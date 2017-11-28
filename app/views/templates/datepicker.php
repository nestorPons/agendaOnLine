
<div class = "contenedorDatepicker">
	<div class="iconClass-container">	
		<i data-action="-1" class="icon-left-open idDateAction" data-disabled=false></i>
		<i data-action="1" class="icon-right-open idDateAction" data-disabled=false></i>
		<input class='datepicker date <?= in_array(Date('md') , $_SESSION['FESTIVOS'] ?? FESTIVOS ) ? 'c-red' : '' ;?>' 
			type='text' 
			value='<?=formatofecha(isset($fecha)?$fecha:Date('Y-m-d'))?>'
			data-festivos-show=true data-min-date=<?= $minDate??null;?>>
	</div>               
</div>