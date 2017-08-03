<?php 
if (!empty($_GET['f'])){
	if (strlen(session_id()) < 1) session_start ();
	$fecha_inicio = $_GET['f'] ;
	$datos_agenda = datosAgenda($fecha_inicio);
	$ids_existentes = json_decode(stripslashes($_GET['ids']));
	view($datos_agenda,$fecha_inicio,$ids_existentes);
}
function view($datosAgenda,$fecha_inicio,$existen_array=false){									
	include_once 'clsLbl.php' ;

	$primer_dia_agenda = sumarFecha($fecha_inicio,-MARGEN_DIAS/2);
	for ($d = 0; $d <= MARGEN_DIAS; $d++){
		$fecha = sumarFecha($primer_dia_agenda,$d);
		$id_fecha = str_replace('-','',$fecha);
		$dia_semana = date('w',strtotime($fecha)) ;
		$array_horas = HORAS[$dia_semana]??false;

		if (empty($existen_array)||array_search($id_fecha,$existen_array)<0){
			?>
			<div id="<?= $id_fecha?>" 
				name="dia[]" 
				class="dia 
					<?= $fecha==$fecha_inicio?'activa':'';?>" 
				diaSemana = "<?= $dia_semana?>" 
			>
				<table class = "tablas tablas-general" >	
					<?php 
					$h = strtotime('06:45') ;
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
							$claseHora=$array[1]=='00'?"num resaltado":"num";
							
							?>
							<tr id='<?= $h?>' class="hora h<?= $h . ' '.$disabled?> " data-hour='<?= $str_hora?>'>
								<td class="<?= $claseHora ?> "><?= $str_hora?> </td>
								<?php
								for ($a=1;$a<=CONFIG['NumAg'];$a++){
									
									$datos = $datosAgenda[$id_fecha][$a][$h]??null ;
									$lbl = new main\Lbl($datos);
									
									?>
									<td class="celda  <?php  if( $lbl->status ) echo'doble ' ; echo $class?> " agenda="<?= $a?>" >
										<?php
											echo $lbl->html ;
											unset( $lbl );
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