<tr>
    <td class="ico">
        <a class= "icon-edit fnEdit x6" value="<?= $nota['id']?>"></a></td>
    <td>
        <?php 
        $f = new DateTime($nota['fecha']);
        echo $f->format('d/m/Y'); 
        ?>
    </td>
    <td><?=$nota['nota']?></td>
</tr>