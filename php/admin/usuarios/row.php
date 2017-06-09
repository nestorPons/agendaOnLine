<?php
// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 Block 8 Baja 9 Activa 
//10 datePass 11 cookie 12 Idioma 13 dateReg 14 dateBaja 
$id = $row[0]??$_GET['id'] ;
$nombre = $row[1]??$_GET['nombre'] ; 
$email = $row[2]??$_GET['email'] ; 
$tel = $row[4]??$_GET['tel'] ; 
$admin  =$row[5]??$_GET['admin'] ; 
$obs = $row[6]??$_GET['obs'] ; 
$activa = $row[14]??$_GET['activa'] ; 
$email_status= empty($email)?"No":"Si";
$obs_status =empty($obs)?"No":"Si";
$clase_estado_baja = $aciva!=0?'ocultar_baja':'';
?> 
<tr id="rowUsuarios<?php echo $id?>" class="<?php echo $clase_estado_baja?>" data-value ="<?php echo$id?>"> 
    <td> 
        <span name="historia" class= "icon-doc-text x6 a" title="Historial de usuario"></span>
        <span name="editar[]" class= "icon-edit x6 a"  title="Editar usuario"></span>
    </td>
    <td name= "id" class="num responsive ">	<?php echo $id. " " ;?></td>
    <td name="nom" class="nom" id="<?php echo strtolower(str_replace(' ', '_', $nombre))?>"><?php echo $nombre;?></td>
    <td name="tel" class="responsive"><?php echo $tel;?></td>
    <td name="email" class="w1" data-value ="<?php echo$email?>"><?php echo $email_status?></td>
    <td name="obs" class="obs responsive" data-value ="<?php echo$obs?>"><?php echo$obs_status?></td>
    <td name="admin" class="hidden" data-value =<?php echo$admin?>></td>
</tr>
