<?php

// 0 Id 1 codigo 2 descripcion 3 Precio 4 tiempo 5 IdFamilia 6 Baja
$id = $service[0]??$_GET['id'];
$codigo = $service[1]??$_GET['codigo'];
$descripcion = $service[2]??$_GET['descripcion'];
$precio = $service[3]??$_GET['precio'];
$tiempo = $service[4]??$_GET['tiempo'];
$familia = $service[5]??$_GET['familia'];
$baja  = $service[6] == 1 ? 'ocultar_baja' : ''  ;

?>

<tr id="rowServicios<?php echo $id ?>" class="fam<?php echo $familia?> <?php echo $baja?>">
    <td>
        <input 
            id ="<?php echo $codigo?>"
            type="checkbox" 
            name="servicios[]" 
            class = "idServicios"
            value="<?php echo $id?>"
            data-time='<?php echo $tiempo?>'
            data-familia="<?php echo $familia?>"
        >
        <label for="<?php echo $codigo?>">
            <?php echo $descripcion?>(<?php echo $tiempo?>min.)
        </label>
    </td>
</tr>