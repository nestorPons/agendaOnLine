<?php 
$idUser = $_SESSION['id_usuario']??false;
if($idUser){
    if (models\Login::logout())
        $Logs->set($idUser, 'logout');  
 
}
$get = (isset($_GET['err']))?"?err=".$_GET['err']:'';
echo("<SCRIPT>window.location='/".CODE_EMPRESA.$get."';</SCRIPT>"); 
//header('location: /'.CODE_EMPRESA . '/err/'.$mensErr);