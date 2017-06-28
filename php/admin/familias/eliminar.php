<?php
header('Content-Type: application/json');
include "../../connect/clsConexion.php";

$block = $conn->row('SELECT Baja FROM familias WHERE IdFamilia = ' . $_GET['id'] .' LIMIT 1')[0] ; 

if ($block == 1){
    $rn = $conn->query('DELETE FROM familias WHERE IdFamilia = ' .  $_GET['id'] );
}else{
    $rn = $conn->query('UPDATE familias SET Baja = 1 WHERE IdFamilia = ' . $_GET['id'] );
}

if ($rn == true) {
    // 0 IdFamilia 1 Nombre 2 Mostrar 3 Baja

    foreach ( $_SESSION['FAMILIAS'] as $key => $value ) {

        if ($_GET['id'] == $value[0] ){
            $key_id = $key ; 
            break;
        }

    }	

    $_SESSION['FAMILIAS'][$key_id][3]  =  1 ;

}else { 

     $r['err'] = ($rn) ; 

}

echo json_encode($rn);