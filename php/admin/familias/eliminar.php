<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$id=$_GET['id'];

//AKI :: Se podria eliminar definitivamente

$sql = "UPDATE familias SET Baja = 1 WHERE IdFamilia = $id;";

$r['success'] = mysqli_query($conexion, $sql) ;

if ($r['success'] == true) {
    // 0 IdFamilia 1 Nombre 2 Mostrar 3 Baja

    foreach ( $_SESSION['FAMILIAS'] as $key => $value ) {

        if ($_GET['id'] == $value[0] ){
            $key_id = $key ; 
            break;
        }

    }	

    $_SESSION['FAMILIAS'][$key_id][3]  =  1 ;
}else { 
     $r['err'] = (mysqli_error($conexion)) ; 
}
echo json_encode($r);