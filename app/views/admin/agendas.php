<form id="frmAg">
	<div class="contenedor-agenda template">
		<i id="" class="icon-trash fnDel"></i>
		<input type="text" class="nombre" id =""  placeholder="Nombre nueva agenda" value="">
		<input id="" type="checkbox" class="mostrar"  value="">
		<label for="">Mostrar a los clientes</label>
	</div>
		<?php 
		$count = 0 ; 
		foreach($Agendas->get() as $agenda){
			if ($count>CONFIG['num_ag']) return \core\Error::array('E041');
			$count ++ ;

			$i = $agenda[0];

			$checked = $agenda[2]==0?"":"checked";
			$nom = $agenda[1];
			
			?>
			<div class="contenedor-agenda">
				<i id=<?=$i?> class="icon-trash fnDel"></i>
				<input type="text" class="nombre" id ="<?='nameAgendaConfig'.$i?>"  placeholder="Nombre" value="<?=$nom?>">
				<input id="a<?=$i?>" type="checkbox" class="mostrar"  value='<?=$i?>' <?=$checked?>>
				<label for="a<?=$i?>">Mostrar a los clientes</label>
			</div>

			<?php
		}?>
</form>
	<div id="nuevaAgenda" class="contenedor-agenda btn-nuevo">
		<i id="" class="icon-plus fnAddAgenda"></i>
		<label>Añadir nueva agenda</label>
	</div>
<br>
<a href="mailto:<?= ADMIN_EMAIL?>">Solicita otra agenda al administrador</a>