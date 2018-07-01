<?php 
$idUser = $_SESSION['id_usuario']??false;
$Login = new \models\Login; 
if ($Login->logout()){
    echo("<SCRIPT>window.location='/".CODE_EMPRESA."?err=" .$_GET['err']."';</SCRIPT>"); 
    //header('location: /'.CODE_EMPRESA . '/err/'.$mensErr);
} else {
    die('Error al salir de la aplicación'); 
}