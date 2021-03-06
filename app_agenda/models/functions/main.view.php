<?php namespace functions ;

function view($fecha_actual = null, $existen_array = false ){	
	global $Device, $_POST;
	$Agenda = new \models\Agendas;
	/**
	 * Funcion inArray multiArray
	 **/
	function _inArray($hour, $multi_array){
		foreach($multi_array as $arr){
			if(in_array($hour,$arr)) return true; 
		}

		return false; 
	}

    date_default_timezone_set('UTC');			
	$fecha = $fecha_actual??Date('Y-m-d');

	$fecha_fin =date ( 'Y-m-d', strtotime ( '+'.MARGIN_DAYS.' day' , strtotime ( $fecha ) ) );

	$lbl = new \models\Lbl();
	$lbl->loadDates( $fecha , $fecha_fin ) ; 

	//Genero variable de session para checkear las citas que se han creado ,eliminado o editado.
	$_SESSION['dating_control'] = $lbl->ids;

	for ($d = 0; $d < MARGIN_DAYS ; $d++){

		$fecha =date ( 'Y-m-d', strtotime ( '+'.$d.' day' , strtotime ( $fecha ) ) );
		$id_fecha = str_replace('-','',$fecha);
		//Me llega desde la app los dias cargados si estan que no me lo vuelva a crear
		if(!(isset($_POST['ids'])&& array_search($id_fecha,$_POST['ids']))){

			$dia_semana = date('w',strtotime($fecha)) ;
			$array_horas = $_SESSION['HORAS'][$dia_semana]??false;
			if (empty($existen_array)||array_search($id_fecha,$existen_array)<0){
				?>
				<div id="<?=$id_fecha?>" name="dia[]" class="dia <?= $fecha == Date('Y-m-d') ?'activa':'';?>" diaSemana = "<?= $dia_semana?>" >
					<table class = "tablas tablas-general" >	
						<?php 
						$h = strtotime($fecha . ' 06:45') ;
						for( $i = 0 ; $i < 96 ; $i++  ){							
							$h =  strtotime ( '+15 minute' ,  $h  )  ;
							$str_hora = date('H:i', $h);

								// si es movil hay que poner pestañas
								$class = '';/*$Device->isMobile()?' hidden_responsive ':'';*/

								$disabled = 'active' ;
								if  (!$array_horas || !_inArray($str_hora,$array_horas)) {
									$class .= "fuera_horario " ;  
									$disabled = (empty(CONFIG['ShowRow']))?'disabled' : '' ;
								} 

								$array = explode(":",$str_hora);
								$clasehora=$array[1]=='00'?"num resaltado":"num";
								
								?>
								<tr id='<?=$h?>' class="hora h<?= $h . ' '.$disabled?> " data-hour='<?= $str_hora?>'>

									<?php
									$agendas = $Agenda->get(); 

									foreach($agendas as $k => $agenda){
										if ($k>=CONFIG['totalAgendas']) break; 
										$a = $agenda[0];
										
										$label = $lbl->html[$h][$a] ?? "<i class='icon-plus fnCogerCita'></i>" ;

										$estadoCelda = (isset($array_horas[$a]) && in_array($str_hora,$array_horas[$a]))? 'dentro_horario':'fueras_horario';
										?>
										<td id = "<?= \core\Tools::generateId($fecha , $str_hora, $a) ?>" 
											class="celda <?php  if( $label ); echo $class . " " . $estadoCelda ?> 
											" agenda="<?= $a?>" >
											<span class="hora alFondo <?= $clasehora ?> "><?= $str_hora?></span>
											<?php			
											echo $label;
											?>
										</td>
										<?php
									}?>
								</tr>
								<?php
						}?>
					</table>
				</div>
				<?php
			}
		}
	}
}
