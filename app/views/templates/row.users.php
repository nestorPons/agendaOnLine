<tr id="rowUsuarios<?=$id?>" class="<?=$clase?>" data-value ="<?=$id?>"> 
    <td> 
        <span name="historia" class= "icon-doc-text x6 a" title="Historial de usuario"></span>
        <span name="editar[]" class= "icon-edit x6 a"  title="Editar usuario"></span>
    </td>
    <td name="id" class="num">	<?=$id. " " ;?></td>
    <td name="nom" class="name" id="<?=strtolower(str_replace(' ', '_', $nombre))?>"><?=$nombre;?></td>
    <?php if(!$Device->isMovile){?>
        <td name="tel" class=""><?=$tel;?></td>
        <td name="email" class="w1" data-value ="<?=$email?>"><?=$email_status?></td>
        <td name="obs" class="obs" data-value ="<?=$obs?>"><?=$obs_status?></td>
        <td name="admin" class="w1" data-value =<?=$admin?>><?=$admin==0?'No':'Si'?></td>
        <?php
    }?>
</tr>
