<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$id=$_GET['id'];
$sql = "UPDATE familias SET Baja = 1 WHERE IdFamilia = $id;";

$r['success'] = mysqli_query($conexion, $sql) or die (mysqli_error($conexion)) ;

if ($r['success'] == true) {
    // 0 IdFamilia 1 Nombre 2 Mostrar 3 Baja

    foreach ( $_SESSION['FAMILIAS'] as $key => $value ) {

        if ($_GET['id'] == $value[0] ){
            $key_id = $key ; 
            break;
        }

    }	

    $_SESSION['FAMILIAS'][$key_id][3]  =  1 ;
}
echo json_encode($r);