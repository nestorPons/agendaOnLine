<?php 
$idUser = $_SESSION['id_usuario']??false;
$Login = new \models\Login; 
if ($Login->logout()){
    $get = (isset($_GET['err']))?"?err=".$_GET['err']:'';
    echo("<SCRIPT>window.location='/".CODE_EMPRESA.$get."';</SCRIPT>"); 
    //header('location: /'.CODE_EMPRESA . '/err/'.$mensErr);
} else {
    die('Error al salir de la aplicación'); 
}