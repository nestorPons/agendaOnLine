<?php

// 0 Id 1 codigo 2 descripcion 3 Precio 4 tiempo 5 IdFamilia 6 Baja
$id = $row[0]??$_GET['id'];
$codigo = $row[1]??$_GET['codigo'];
$descripcion = $row[2]??$_GET['descripcion'];
$precio = $row[3]??$_GET['precio'];
$tiempo = $row[4]??$_GET['tiempo'];
$familia = $row[5]??$_GET['familia'];
$baja  = $row[6] == 1 ? 'ocultar_baja' : ''  ;

?>

<tr id="rowServicios<?php echo $id ?>" class="fam<?php echo $familia?> <?php echo $baja?>">
    <td>
        <input 
            type="checkbox" 
            name="servicios[]" 
            id ="<?php echo $codigo?>"
            value="<?php echo $id?>"
            data-time='<?php echo $tiempo?>'
            data-familia="<?php echo $familia?>"
        >
        <label for="<?php echo $codigo?>">
            <?php echo $descripcion?>(<?php echo $tiempo?>min.)
        </label>
    </td>
</tr>