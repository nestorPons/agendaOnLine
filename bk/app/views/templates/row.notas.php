<tr id="trNotas<?=$nota['id']?>" class="<?=str_replace('-','',$nota['fecha'])?> mostrar">
    <td class="ico" >
        <a class= "icon-edit fnEdit x6" value="<?= str_replace('-','',$nota['id'])?>"></a>
    </td>
    <td class="idid">
        <?=$nota['id']?>
    </td>
    <td class="idFecha">
        <?php 
        $f = new DateTime($nota['fecha']);
        echo $f->format('d/m/Y'); 
        ?>
    </td>
    <td class="idHora">
        <?php 
        $h = new DateTime($nota['hora']);
        echo $h->format('H:m'); 
        ?>
    </td>
    <td class="idDescripcion"><?=$nota['nota']?></td>
</tr>