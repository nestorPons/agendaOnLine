<?php
include "../../connect/config.controller.php";
include "../main/lbl.class.php";
include '../horarios/class.php';

$fecha = $_GET['date'] ;

$id_fecha = str_replace('-','',$fecha);
$dia_semana = date('w',strtotime($fecha)) ;

$horarios = new horarios\Horarios ;
$lbl = new main\Lbl ;

$lbl->loadDates( $fecha ) ;
$arr_horas_ocupadas = array_column($lbl->data, 'tiempoTotal' , 'hora') ;
$horas = $horarios->hours($dia_semana);
$array_horas = $horas[$dia_semana]??false;

echo('<pre>');
    var_dump($arr_horas_ocupadas); 
echo('</pre>');

//AKI :: pintandolas horas 

?>
<table id="<?= $id_fecha ?>">
    <?php 
    foreach ( $array_horas as $h ){
        $estado = (array_key_exists($h.':00' , $arr_horas_ocupadas)===false)?'':'ocupada';
        ?>
        <tr id="">
            <td class="hora">
                <label for="" class="label">
                    <input type="radio" id="" name="hora[]" value="">
                    <span class=""><?= $h ?>  // <?= $estado ?></span>

                </label>
            </td>
        </tr>
        <?php
    }
    ?>
</table>