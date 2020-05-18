<?php
	require URL_VIEWS . 'header.php';
	$url_validate= '/'. $Empresa->code() .'/'. 'validar';
?>
	</head>
    <body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
        <main  id="login">
            <div class="login login-form ">
                <section id="pinpass">
                    <a href= "<?=CONFIG['web']??''?>"  target="_blank">
                        <img id="logo" src="./<?=URL_LOGO?>" alt="logo image"/>
                    </a>
                    <h1 class="heading">Introduzca pin</h1>
                    <hr>
                    <form id="frmPinpass"  defaultbutton="Entrar" >
                        <input type="hidden"  id="ancho" name="ancho">
                        <input type="hidden" id="empresa">
                        <div class="iconClass-container">
                            <input type="number" class="pin" id="pinpass"  name="pinpass" placeholder="Introduzca su numero pin" 
                            min=0001 max=9999 title="Pin de 4 dígitos" required>
                            <span class="iconClass-inside icon-key icon-left"></span>
                        </div>
                        <input type="button" class="btn-danger logout"  value="Cancelar" >
                    </form>

                </section>
            </div>
        </main>
        <?php include URL_TEMPLATES . 'login_footer.php'?>
        <div id="loader" class="popup-overlay hide">
         <i class="lnr-sync animate-spin"></i>
        </div>
	</body>
</html>