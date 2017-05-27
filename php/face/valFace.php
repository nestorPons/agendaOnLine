<?php
include 'connect/conexion.php';     

function usuarioRegistrado($idUsuario,$permisoAdministrador,$bloqueado){
    $_SESSION['id_usuario'] = $idUsuario;
	registrarEvento(0,0, $idUsuario);

    if ($permisoAdministrador==1){
         header("Location: ../admin/agendas.php?agenda=0");
    }else{
        if($bloqueado==1){
            //REDIRIJO A USUARIOS BLOQUEADOS
            header("Location: ../user/block.html");
        }else{
			header("Location: ../user/index.php");  
        }
    }
}

    if (isset($_GET['usuario'])){
    //LOGIN FACEBOOK
        $usuario = htmlentities($_GET['usuario'], ENT_QUOTES,'UTF-8');
        $email   = htmlentities($_GET['email'], ENT_QUOTES,'UTF-8');
		$_SESSION['email']  = $email;
		$_SESSION['nombre']	= $_GET['usuario'];

        if ($row_login = mysqli_fetch_array(mysqli_query($conexion,"SELECT * FROM usuarios WHERE Email LIKE '$email'"))){
            if ($email=='undefined'|| empty($email)){
                ?>
                <script>
				    alert('No se puede acceder desde facebook, pongase en contacto con el administrador');
				    window.location.href='../index.html';
			    </script>
			    <?php 
            }else{
                usuarioRegistrado($row_login["Id"],$row_login['Admin'],$row_login['Block']);
            }
        }else{
            if ($email=='undefined'){
                ?>
                <script>
				    alert('No se puede acceder con facebook, pongase en contacto con el administrador');
				    window.location.href='../index.html';
			    </script>
			    <?php 
            }else{
                header("location:saveFace.php?usuario=".urldecode($_GET['usuario'])."&email=".urldecode($_GET['email']));
            }
            
        }
 ?>