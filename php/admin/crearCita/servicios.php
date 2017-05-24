<?php
include "../../../php/menus/servicios.php";
?>
<table class ='tablas  contenedorServicios' >
	<tbody>
		<?php
		foreach ($_SESSION['SERVICIOS'] as $data){
			// 0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
			?>
				<tr id="rowServicios<?php echo $data[0]?>" class="fam<?php echo $data[5]?>">
					<td>
						<label for="<?php echo $data[1]?>">
							<input 
								type="checkbox" 
								name="servicios[]" 
								id ="<?php echo $data[1]?>"
								value="<?php echo $data[0]?>"
								data-time='<?php echo $data[4]?>'
								data-familia="<?php echo $data[5]?>"
							>
							'<?php echo $data[2]?>' ('<?php echo $data[4]?>' min.)
						</label>
					</td>
				</tr>
			<?php
		}
		?>
	</tbody>
</table>
<button type="button" id="btnCancelar" class="btn-danger cancelar">Cancelar</button>
<button type="button" id="btnSiguiente" class="btn-success siguiente">Siguiente<i  class="icon-angle-right"></i></button>