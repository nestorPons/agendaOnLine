<table id="tableHistory" class="tablas-group">
<?php

	foreach($records as  $r){	

		?>
		<tr id="tr<?=$r['id']?>" 
			class="<?=$r['id'].$r['idSer']?>" 
			idCita="<?=$r['idCita']?>" 
			idser="<?=$r['idSer']?>"
			fecha="<?=$r['fecha']?>" 
			hora="<?=$r['hora']?>">
			<td idSer="<?=$r['id']?>">
				<i class="icon-cancel fnDel"></i>
				<i class="icon-load c5 animate-spin hidden"></i>
			</td>
			<td class="padding5"><?=$r["fecha"]?> a las <?=$r['hora']?></td>
			<td class="padding5 aling-left"><?=$r['descripcion']?></td> 
		</tr>
		<?php
	}
		
?>
</table>