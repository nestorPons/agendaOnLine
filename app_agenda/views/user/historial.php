<div id="lineasHistorial">
<?php

foreach($historial as  $h){?>
    <div class="cita" idCita="<?=$h['id']?>" data-fecha="<?=$h['fecha']?>" data-hora="<?=$h['hora']?>" data-agenda="<?=$h['agenda']?>">

        <i class="del lnr-cross-circle"></i>   


        <span class="fecha"><?= \core\Tools::formatofecha($h['fecha'])?> a las <?=$h['hora']?></span>
        <div class="servicios">
        <?php    
        $ser = $User->getCitas($h['id']); 
        foreach($ser as $s){?>
                <div class="servicio"> <?= $s['descripcion']?> </div>
            <?php
        }?>
        </div>
    </div>
    <?php
}?>
</div>
