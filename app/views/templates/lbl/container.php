 <div id='idCita_<?=$val['idCita']?>' class='lbl row_<?=$rows?>' >
    <div id ='<?=$val['idUsuario']?>' class='nombre'>
        <span class ='icon-user-1'></span> 
        <span class = 'text-value'><?=$val['nombre']?></span>
    </div>
    <div class='iconos aling-right'>               
        <span class ='icon-pencil-1 fnEdit '></span> 
        <span class ='icon-trash fnDel'></span>  
        <span class ='icon-star fnMove'></span> 
    </div>
    <div class='note '><?=$note?></div> 											  
    <div class='servicios <?=$rows?>'>          
       <?= $servicies?>
    </div> 
</div>
