<?php namespace functions ;

function view($fecha_inicio = null, $existen_array = false ){	
	global $Device;
		
    date_default_timezone_set('UTC');			
	$fecha = $fecha_inicio??Date('Y-m-d') ;
	$dias = round(MARGIN_DAYS/2);

	$fecha_inicio =date ( 'Y-m-d', strtotime ( '-'.$dias.' day' , strtotime ( $fecha ) ) );
	$fecha_fin =date ( 'Y-m-d', strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) );

	$lbl = new \models\Lbl();
	$lbl->loadDates( $fecha_inicio , $fecha_fin ) ; 

	//Genero variable de session para checkear las citas que se han creado ,eliminado o editado.
	$_SESSION['dating_control'] = $lbl->ids;

	for ($d = 0; $d <= ($dias * 2) ; $d++){
		$fecha =date ( 'Y-m-d', strtotime ( '+'.$d.' day' , strtotime ( $fecha_inicio ) ) );
		$id_fecha = generateId($fecha);
		$dia_semana = date('w',strtotime($fecha)) ;
		$array_horas = $_SESSION['HORAS'][$dia_semana]??false;

		if (empty($existen_array)||array_search($id_fecha,$existen_array)<0){
			?>
			<div id="<?=$id_fecha?>" name="dia[]" class="dia <?= $fecha== Date('Y-m-d') ?'activa':'';?>" diaSemana = "<?= $dia_semana?>" >
				<table class = "tablas tablas-general" >	
					<?php 
					$h = strtotime($fecha . ' 06:45') ;
					for( $i = 0 ; $i <= 96 ; $i++  ){							
						$h =  strtotime ( '+15 minute' ,  $h  )  ;
						$str_hora = date('H:i', $h);

						if ($array_horas) {	
							//AKI :: si es movil hay que poner pestañas
							//$class = $Device->isMovile&&$a!=1?' hidden_responsive ':'';
							$class="";
							if  (array_search($str_hora,$array_horas)===false) {
								$class .= "fuera_horario " ;  
								$disabled = (empty(CONFIG['ShowRow']))?' disabled ' : '' ;
							} else {
								$disabled = '' ;
							}

							$array = explode(":",$str_hora);
							$clasehora=$array[1]=='00'?"num resaltado":"num";
							
							?>
							<tr id='<?=$h?>' class="hora h<?= $h . ' '.$disabled?> " data-hour='<?= $str_hora?>'>
								<td  class="<?= $clasehora ?> "><?= $str_hora?> </td>
								<?php
								for ($a=1;$a<=CONFIG['num_ag'];$a++){
									$label = $lbl->html[$h][$a] ?? false ;
									
									?>
									<td id = "<?= generateId($fecha , $str_hora, $a) ?>" class="celda <?php  if( $label ); echo $class?> " agenda="<?= $a?>" >
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