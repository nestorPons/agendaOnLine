<?php
$cls_festivos = (!empty(FESTIVOS)) && (in_array(Date('md') , FESTIVOS )) ? 'c-red' : '' ;
$fecha = isset($_POST['fecha'])?$_POST['fecha']:Date('Y-m-d');
?>
<div class = "contenedorDatepicker">
	<div class="iconClass-container">	
		<i data-action="-1" class="icon-left-open idDateAction" data-disabled=false></i>
		<i data-action="1" class="icon-right-open idDateAction" data-disabled=false></i>
	
		<input class='datepicker date <?= $cls_festivos?>' 
			type='text' 
			value='<?=core\Tools::formatofecha($fecha)?>'
			data-festivos-show=true data-min-date=<?= $minDate??null;?>>
	</div>               
</div>