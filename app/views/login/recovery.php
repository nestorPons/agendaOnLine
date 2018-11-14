<?php 
    include URL_VIEWS . 'login/header.php';
    $idUser = substr($_GET['args'],-4);
    $token = $_GET['args'];
?>
<!DOCTYPE html>
<html lang="es">
    <?php include URL_VIEWS . 'login/header.php' ;?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
        <section class="login login-form ">
            <section id="newPass"  >
                <h1 class="heading">Restablecer contraseña</h1>
                <hr>
                <form id="frmNewPass">
                    <input type="hidden" id="idUser" value=<?=(int)$idUser?>>
                    <input type="hidden" id="token" value=<?=$token?>>
                    <div class="iconClass-container icon-left">
                        <input type="password" id="pass"  placeholder="Introduzca nueva contraseña" required>
                        <span class="iconClass-inside icon-eye"></span>
                    </div>
                    <div class="iconClass-container icon-left">
                        <input type="password" id="rpass"  placeholder="repita nueva contraseña" required>
                        <span class="iconClass-inside icon-eye"></span>
                    </div>
                   <button type="submit" class="btn-success btnLoad" data-value="Aceptar">Aceptar</button>
                </form>
            </section>
        </div>
    <script  src="/js/recovery.js?ver=<?=VERSION?>"></script>
	</body>
</html>