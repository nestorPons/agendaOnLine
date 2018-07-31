<div id="lineasHistorial">
<?php
foreach($historial as  $h){?>
    <div class="cita" idCita="<?=$h['id']?>">

        <i class="del lnr-cross-circle"></i>   


        <span class="fecha"><?= $h['fecha']?> a las <?=$h['hora']?></span>
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
