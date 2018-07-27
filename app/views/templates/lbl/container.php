 <div id='idCita_<?=$val['idCita']?>' idcita=<?=$val['idCita']?> 
    lastMod="<?=$val['lastMod']?>"  
    class='lbl row_<?=$rows?> <?= $color?> <?php if($noMovile){echo('width_'.CONFIG['totalAgendas']);}?>' 
    tiempo="<?=$val['tiempoTotal']?>">
    <div id ='<?=$val['idUsuario']?>' class='nombre'>
        <i class ='icon-user-1'></i> 
        <span class = 'text-value'><?=$val['nombre']?></span>
    </div>
    <div class='iconos'> 
    <?php if($val['idUsuario']==$val['usuarioCogeCita']&&$val['admin']!=1){?>
        <i class ='lnr-laptop-phone' title="La cita ha sido cogida por el usuario"></i>  
    <?php }?>
        <?php if($number_services >= $rows){?>
            <i class ='icon-angle-down fnExtend' title="Desplegar cita" ></i>  
            <?php
        }?>
        <div class='icons_crud'>           
            <i class ='icon-pencil-1 fnEdit ' title="Editar cita"></i> 
            <i class ='icon-trash fnDel' title="Eliminar cita"></i>  
        </div>
        <i class ='icon-move fnMove' Title="Mover cita"></i> 
    </div>
   										  
    <div class='servicios <?=$rows?>'>          
       <?= $servicies?>
    </div> 
     <div class='note <?=$val['obs']?'show':''?>'>
        <i class ='icon-note'></i>   
        <i class ='text_note'><?=$val['obs']??null?></i>
     </div> 	
</div>
