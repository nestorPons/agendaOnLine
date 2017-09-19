
<table class = "dia activa" id="<?= $id_fecha ?>" >
    <tr>
        <th><?=$id_fecha?></th>
    </tr>
    <?php 
    $unidadesTiempo = 0 ;
    if ( $array_horas ) {
        foreach ( $array_horas as $key => $h ){
            $cierre = in_array($h , $horarios->horas_cierre[$dia_semana])?'cierre':'';
            $str_h =  $h . ':00';
            $unidadesTiempo = (array_key_exists( $str_h , $arr_horas_ocupadas)===false)? $unidadesTiempo: ceil($arr_horas_ocupadas[$str_h] / 15) ;
            ?>
            <tr>
                <td>
                    <label for="hora<?= $key ?>" class="label <?= $unidadesTiempo != 0 ? 'ocupado' : '' ?> ">

                        <input type="radio" id="hora<?= $key ?>" class="horas <?= $cierre ?>" name="hora[]" value="<?=$h?>" <?= $unidadesTiempo != 0 ? 'disabled' : '' ?> > 
                        <span class="  "><?= $h ?> </span>

                    </label>
                </td>
            </tr>
            <?php
       
            $unidadesTiempo != 0 ? $unidadesTiempo -= 1 : 0 ;
        }
    }
    ?>
</table>