<?php 
	include URL_TEMPLATES . '/header.php' ;
    $idUser = substr($_GET['args'],-4);
    $token = $_GET['args'];
    $url = URL_PROTOCOL .  $_SERVER['SERVER_NAME'] .'/'. CODE_EMPRESA .'/'. 'validar';
	?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=CODE_EMPRESA?>" class="<?=CLASS_BACKGROUND?>" >
        <div id="login" class="login login-form ">
            <section id="newPass"  >
                <h1 class="heading">Restablecer contraseña</h1>
                <hr>
                <form id="frmNewPass" method="POST" action="<?=$url?>">
                    <input type="hidden" name="idUser" value=<?=(int)$idUser?>>
                    <input type="hidden" name="token" value=<?=$token?>>
                    <div class="iconClass-container icon-left">
                        <input type="password" id="fakePass"  placeholder="Introduzca nueva contraseña" required>
                        <input type="hidden" name="pass" id="pass">
                        <span class="iconClass-inside icon-eye"></span>
                    </div>
                    <div class="iconClass-container icon-left">
                        <input type="password" id="fakePassR"  placeholder="repita nueva contraseña" required>
                        <span class="iconClass-inside icon-eye"></span>
                    </div>
                   <button type="submit" class="btn-success btnLoad" data-value="Aceptar">Aceptar</button>
                </form>
            </section>
        </div>
	</body>
</html>