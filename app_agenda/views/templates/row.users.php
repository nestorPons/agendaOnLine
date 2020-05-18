<tr id="rowUsuarios<?=$id?>" class="<?=$clase?> row_usuario row" data-value ="<?=$id?>" data-color="<?=$color??''?>" data-status=<?=$status?>> 
    <td class="botons"> 
        <span name="historia" class= "icon-doc-text " title="Historial de usuario"></span>
        <span name="editar[]" class= "icon-edit x6 a"  title="Editar usuario"></span>
    </td>
    <td name="id" class="id">	<?=$id. " " ;?></td>
    <td name="nom" class="name busqueda" id="<?=strtolower(str_replace(' ', '', $nombre))?>"><?=$nombre;?></td>

    <td name="tel" class="tel"><?=$tel;?></td>
    <td name="email" class="email" data-value="<?=$email?>"><?=$email?></td>
    <td name="obs" class="obs" data-value ="<?=$obs?>"><?=$obs_status?></td>
    <td name="admin"  class="admin" data-value =<?=$admin?>><?=$admin==0?'No':'Si'?></td>

</tr>
