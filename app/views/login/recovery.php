<?php 

    include URL_TEMPLATES .    'header.php';
    $idUser = substr($_GET['args'],-4);
    $token = $_GET['args'];
	?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
        <div id="login" class="login login-form ">
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
    <script  src="/js/lib/jquery.min.js" ></script>
    <script  src="/js/recovery.js" ></script>
	</body>
</html>