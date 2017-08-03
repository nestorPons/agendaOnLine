<?php

// 0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
$id = $row[0]??$_GET['id'];
$codigo = $row[1]??$_GET['codigo'];
$descripcion = $row[2]??$_GET['descripcion'];
$precio = $row[3]??$_GET['precio'];
$tiempo = $row[4]??$_GET['tiempo'];
$familia = $row[5]??$_GET['familia'];
$baja = $row[6]==1?'ocultar_baja':'';
?>
<tr id="rowServicios<?= $id?>" 
    class="fam<?=$familia?> <?=$baja?>"  
    name="<?= normaliza($codigo)?>" 
    familia = "<?=$familia?>"
    value=<?= $id?> >
    <td class="ico"><a name="editar[]" class= "icon-edit x6" value="<?= $id?>"></a></td>
    <td name='cod'  id = "<?= normaliza($codigo)?>"  class='aling-left cod'><?= $codigo?></td>
    <td name='des' class="nom"><?= $descripcion?> </td>
    <td name='time' class ="ico" ><?= $tiempo?></td>
    <td name='price' class="hidden" data-value=<?= $precio?>></td>
</tr>
