<?php
// 0 Id 1 codigo 2 descripcion 3 Precio 4 tiempo 5 IdFamilia 6 Baja
$id = $ser[0]??$_POST['id'];
$codigo = $ser[1]??$_POST['codigo'];
$descripcion = $ser[2]??$_POST['descripcion'];
$precio = $ser[3]??$_POST['precio'];
$tiempo = $ser[4]??$_POST['tiempo'];
$familia = $ser[5]??$_POST['familia'];
$baja  = $ser[6] == 1 ? 'ocultar_baja' : ''  ;

?>

<tr id="rowServicios<?=$id ?>" class="fam<?=$familia?> <?=$baja?>">
    <td>
        <input 
            id ="<?=$codigo?>" 
            type="checkbox" 
            name="servicios[]" 
            class = "idServicios"
            value="<?=$id?>"
            data-time='<?=$tiempo?>'
            data-familia="<?=$familia?>"
        >
        <label for="<?=$codigo?>">
            <span class="descripcion"><?=$descripcion?></span>
            <span class="tiempo"> (<?=$tiempo?>min.)</span>  
        </label>
    </td>
</tr>