 <div id='idCita_<?=$val['idCita']?>' idcita=<?=$val['idCita']?> lastMod="<?=$val['lastMod']?>"  class='lbl row_<?=$rows?> width_<?=CONFIG['num_ag']?>' >
    <div id ='<?=$val['idUsuario']?>' class='nombre'>
        <span class ='icon-user-1'></span> 
        <span class = 'text-value'><?=$val['nombre']?></span>
    </div>
    <div class='iconos'>    
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
