<?php namespace main ;

function view($existen_array=false){									
	$fecha = Date('Y-m-d') ;
	
	$dias = round(MARGEN_DIAS/2);

	$fecha_inicio =date ( 'Y-m-d', strtotime ( '-'.$dias.' day' , strtotime ( $fecha ) ) );
	$fecha_fin =date ( 'Y-m-d', strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) );

	$lbl = new Lbl();
	$lbl->loadDates( $fecha_inicio , $fecha_fin ) ; 

	for ($d = 0; $d <= ($dias * 2) ; $d++){
		$fecha =date ( 'Y-m-d', strtotime ( '+'.$d.' day' , strtotime ( $fecha_inicio ) ) );
		$id_fecha = str_replace('-','',$fecha);
		$dia_semana = date('w',strtotime($fecha)) ;

		$array_horas = HORAS[$dia_semana]??false;

		if (empty($existen_array)||array_search($id_fecha,$existen_array)<0){
			?>
			<div id="<?= $id_fecha?>" 
				name="dia[]" 
				class="dia 
					<?= $fecha== Date('Y-m-d') ?'activa':'';?>" 
				diaSemana = "<?= $dia_semana?>" 
			>
				<table class = "tablas tablas-general" >	
					<?php 
					$h = strtotime($fecha . ' 06:45') ;
					for( $i = 0 ; $i <= 96 ; $i++  ){											
						$h =  strtotime ( '+15 minute' ,  $h )  ;
						$str_hora = date('H:i', $h);

						if ($array_horas) {	
							$class = $_SESSION['esMobil']&&$a!=1?' hiddenim ':'';
							if  (array_search($str_hora,$array_horas)===false) {
								$class .= "fuera_horario " ;  
								$disabled = (empty(CONFIG['ShowRow']))?' disabled ' : '' ;
							} else {
								$disabled = '' ;
							}

							$array = explode(":",$str_hora);
							$clasehora=$array[1]=='00'?"num resaltado":"num";
							
							?>
							<tr id='<?= $h?>' class="hora h<?= $h . ' '.$disabled?> " data-hour='<?= $str_hora?>'>
								<td class="<?= $clasehora ?> "><?= $str_hora?> </td>
								<?php
								for ($a=1;$a<=CONFIG['NumAg'];$a++){
									$label = $lbl->html[$h][$a] ?? false ;
									?>
									<td class="celda  <?php  if( $label ) echo'doble ' ; echo $class?> " agenda="<?= $a?>" >
										<?php
																							
										echo $label;

										?>
									</td>
									<?php
								}?>
							</tr>
							<?php
						}
					}?>
				</table>
			</div>
			<?php
		}
	}
}