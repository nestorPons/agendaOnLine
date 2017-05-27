<?php
include "../../../php/menus/servicios.php";
?>
<table class ='tablas-group  contenedorServicios' >
	<tbody>
		<?php
		$n = 0; 
		foreach ($_SESSION['SERVICIOS'] as $row){
			// $n para niniciar los servicios de la primera familia
			$n++;
			$ini_familia = $n==1 ?   $row[5]  : $ini_familia;
			// 0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
			?>
				<tr id="rowServicios<?php echo $row[0]?>" 
				class="fam<?php echo $row[5]?> <?php echo $row[5] == $ini_familia ? "" : "disabled"; ?>">
					<td>
						<label for="<?php echo $row[1]?>">
							<input 
								type="checkbox" 
								name="servicios[]" 
								id ="<?php echo $row[1]?>"
								value="<?php echo $row[0]?>"
								data-time='<?php echo $row[4]?>'
								data-familia="<?php echo $row[5]?>"
							>
							'<?php echo $row[2]?>' ('<?php echo $row[4]?>' min.)
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