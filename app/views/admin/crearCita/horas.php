
<table class = "dia activa" id="<?=$id_fecha?>" >
    <tr>
        <th><?=$id_fecha?></th>
    </tr>
    <?php 

    if ( $array_horas ) {
        $count = count($array_horas) ;
        $midle = round($count / 2) ;

        for ( $i = 0 ; $i < $midle ; $i++ ){ 
            $h = $array_horas[$i];
            $hh = $array_horas[$i+$midle]??0;
            
            $cls_status_1 = $Horarios->out_time($h,$id_fecha, CONFIG['minTime'])
                ?'ocupado'
                :$Horarios->cls_status($hh, $arr_horas_ocupadas,'ocupado');
            $cls_status_2 =  $Horarios->out_time($h,$id_fecha, CONFIG['minTime'])
                ?'ocupado':
                $Horarios2->cls_status($hh, $arr_horas_ocupadas,'ocupado');
            $std_radio_1 =  empty($cls_status_1) ? '' :'disabled';
            $std_radio_2 =  empty($cls_status_2) ? '' :'disabled';
            ?>
            <tr>
                <td>
                    <label for="hora<?=$i?>" class="label <?=$cls_status_1?> ">

                        <input type="radio" id="hora<?=$i?>" class="horas <?=$cls_status_1?>" name="hora[]" value="<?=$h?>" <?=$std_radio_1?> > 
                        <span><?=$h?> </span>
                        
                    </label>
                </td>
                <td>
                    <?php
                    if ($i + $midle < $count) {
                        ?>
                        <label for="hora<?=$i+$midle?>" class="label <?= $cls_status_2 ?> ">

                            <input type="radio" id="hora<?=$i+$midle?>" class="horas <?=$cls_status_2?>" name="hora[]" value="<?=$hh?>" <?=$std_radio_2?> > 
                            <span><?= $hh ?> </span>

                        </label>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>