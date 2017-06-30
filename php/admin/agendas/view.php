<?php namespace agendas;


if (!empty($_GET)){
	require_once "../connect/conexion.php";
	$conexion = conexion(true,false,true);

	include 'agendas/core.php';

	$fecha_inicio = $_GET['f'];
	$datos_agenda = datosAgenda($fecha_inicio);
	$ids_existentes = json_decode(stripslashes($_GET['ids']));
	view($datos_agenda,$fecha_inicio,$ids_existentes);
}

function view($datosAgenda,$fecha_inicio,$existen_array=false){									

$n = 40; //borrar
	$primer_dia_agenda = sumarFecha($fecha_inicio,-MARGEN_DIAS/2);
	for ($d = 0; $d <= MARGEN_DIAS; $d++){
		$fecha = sumarFecha($primer_dia_agenda,$d);
		$id_fecha = str_replace('-','',$fecha);
		if (empty($existen_array)||array_search($id_fecha,$existen_array)<=0){
			?>
			<div id="<?php echo $id_fecha?>" 
				name="dia[]" 
				class="dia 
					<?php 
					echo $fecha==$fecha_inicio?'activa':'';
					?>" 
				diaSemana = "<?php echo date('w',strtotime($fecha) )?>" 
			>
				<table class = "tablas tablas-general" >	
					<?php
					for($h =  strtotime(CONFIG['hora_ini']); $h <=  strtotime(CONFIG['hora_fin']) ; $h += strtotime("+15 minutes", strtotime($h))){	
						$hora = date('H:i', $h);
						$array_horas = HORAS[date('w',strtotime($fecha))]??false;
						if ($array_horas) {
							$horario = (array_search($hora,$array_horas)>0)?"":"fuera_horario "; 
							$disabled = CONFIG['ShowRow']==0&&(array_search($hora,$array_horas)<=0)?'disabled':'';

							$array = explode(":",$hora);
							$claseHora=$array[1]=='00'?"num resaltado":"num";
							?>
							<tr id='<?php echo $h?>' class="hora h<?php echo $h . ' ' . $disabled?> " data-hour='<?php echo $hora?>'>
								<td class="<?php echo $claseHora ?> "><?php echo $hora?> </td>
								<?php
								for ($a=1;$a<=CONFIG['NumAg'];$a++){
									$datos = $datosAgenda[$id_fecha][$a][$h]??null ;
									$obj_lbl[$h.$a] = new Lbl($datos);
									$lbl = $obj_lbl[$h.$a] ;
									
									?>
									<td class="celda  <?php  if( $lbl->status ) echo'doble '?>" agenda="<?php echo$a?>" >
										<?php

											echo $lbl->html ;
										
										?>
									</td>
									<?php
								/*
									$citas = $datosAgenda[$fecha][$h][$a]??0;
									$class = $_SESSION['esMobil']&&$a!=1?' hiddenim ':'';
									$class .=  $horario;
									?>
									<td name="celda"  class="celda agenda<?php echo$a.' '.$class?>"  data-agenda="<?php echo$a?>" >
											<?php
												if(!empty($citas)){
													array_multisort($citas); //ordeno array para los que se montan aparezcan seguidos 

													for($t = 0; $t < count($citas);$t++){
														$cita = $citas[$t] ;
																						
														$cAn =  $citaAnterior[$a]??null;
														$valCita[$a] = $cAn != $cita['idCita'];
														$citaAnterior[$a] = $cita['idCita'];
														
														$clsIA = count($citas)>1?"show":"hidden";
														$iconAttention =  "<span class='icon-attention aling-right $clsIA' title='¡ATENCION, CITAS SUPERPUESTAS!'></span>";
														$codA = $codigoAnterior[$a]??null;
														$valCod[$a] = $codA != $cita['codigo'];
														$codigoAnterior[$a] = $cita['codigo']??null;
														
													
														$clase[$a] = " ic".$cita['idCita']." cod".$cita['idCodigo']." ocupada ";
														if($t>0){ $clase[$a] .= "hidden";} //oculto si hay mas de una tabla (cita)
														?>
															<table class="cita <?php echo $clase[$a]?>"
																idcita= "<?php echo $cita['idCita']?>" 
																codigo= "<?php echo $cita['codigo']?>" 
																idcodigo = "<?php echo $cita['idCodigo']?>"
																idser =  "<?php echo $cita['id']?>"
															>
																<tr>
																<?php
																if($valCita[$a]){
																	?>
																	<td>
																		<span class='icon-user-1'><?php echo $cita['nombre']?></span>
																		<?php  echo $iconAttention?>
																		<span class='icon-cancel aling-right '></span>
																		<span class='aling-right numidcita'><?php echo $cita['idCita']?></span>
																	</td>
																	<td class="note <?php echo empty($cita['obs'])?"":"show";?> ">
																		<div class="iconClass-container icon-right">
																			<span class='icon-note'></span>
																			<input type='text' class="" value="<?php echo $cita['obs']?>">
																			<span class="iconClass-inside icon-load  animate-spin"></span>
																			<span class="iconClass-inside icon-ok"></span>
																		</div>
																	</td>
																	<td>
																		<span class='icon-angle-right'></span>
																		<span class="<?php echo $cita['codigo']?>"><?php echo $cita['codigo']?><span>
																	</td>
														<?php
													}else 
													if($valCod[$a] ){
														?>
															<td><?php  echo $iconAttention?></td>
															<td></td>
															<td>
																<span class='icon-angle-right'></span>
																<span class="nomCod"><?php echo $cita['codigo']?><span>
															</td>
														<?php
													}else{
														?>
															<td><?php  echo $iconAttention?></td>
															<td>&nbsp;</td>
															<td></td>
														<?php
													}
													?>
														</tr>
													</table>
													<?php
												}
											}else{
												$clase[$a] ="";
												$valCita[$a] = false;
												$valCod[$a] = false;
												?>
												<i class='icon-plus x4'></i>
												<?php
											}
										?>
									</td>
									<?php
								*/}?>
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