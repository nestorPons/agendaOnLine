 <div id='idCita_<?=$val['idCita']?>' idcita=<?=$val['idCita']?> 
 lastMod="<?=$val['lastMod']?>"  class='lbl row_<?=$rows?> width_<?=CONFIG['totalAgendas']?>' tiempo="<?=$val['tiempoTotal']?>">
    <div id ='<?=$val['idUsuario']?>' class='nombre'>
        <span class ='icon-user-1'></span> 
        <span class = 'text-value'><?=$val['nombre']?></span>
    </div>
    <div class='iconos'> 
        <?php if($number_services >= $rows){?>
            <span class ='icon-angle-down fnExtend' ></span>  
            <?php
        }?>
        <div class='icons_crud'>           
            <span class ='icon-pencil-1 fnEdit '></span> 
            <span class ='icon-trash fnDel'></span>  
        </div>
        <span class ='icon-move fnMove'></span> 
    </div>
   										  
    <div class='servicios <?=$rows?>'>          
       <?= $servicies?>
    </div> 
     <div class='note <?=$val['obs']?'show':''?>'>
        <span class ='icon-note'></span>   
        <span class ='text_note'><?=$val['obs']??null?></span>
     </div> 	
</div>
