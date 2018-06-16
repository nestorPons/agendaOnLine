<?php
// 0 Id 1 codigo 2 descripcion 3 Precio 4 tiempo 5 IdFamilia 6 Baja
$id = $serv[0];
$codigo = $serv[1];
$descripcion = $serv[2];
$precio = $serv[3];
$tiempo = $serv[4];
$familia = $serv[5];
$baja = $serv[6]==1?'ocultar_baja':'';
?>

<tr id="rowServicios<?=$id?>" 
    class="fam<?=$familia?> <?=$baja?>"  
    name="<?=\core\Tools::normalize($codigo)?>" 
    familia = "<?=$familia?>"
    value=<?= $id?> >
    <td class="ico"><a name="editar[]" class= "icon-edit x6" value="<?= $id?>"></a></td>
    <td name='cod'  id = "<?=$id?>"  class='aling-left cod'><?= $codigo?></td>
    <td name='des' class="nom"><?=$descripcion?> </td>
    <td name='time' class ="ico" ><?= $tiempo?></td>
    <td name='price' class="hidden" data-value=<?= $precio?>></td>
</tr>