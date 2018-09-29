<?php
	require URL_VIEWS . 'header.php';
	$url_validate= '/'. $Empresa->code() .'/'. 'validar';
?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
		<div id="login" class="login login-form ">
            <section id="pinpass">
                <a href= "<?=CONFIG['web']??''?>"  target="_blank">
					<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
				</a>
                <h1 class="heading">Introduzca pin</h1>
                <hr>
                <form id="frmPinpass" method="POST" action='<?= $url_validate ?>' defaultbutton="Entrar" >
                    <input type="hidden"  id="ancho" name="ancho">
                    <input type="hidden" id="empresa"  value="<?php  ?>">
                    <div class="iconClass-container">
                        <input type="number" class="pin" id="pinpass"  name="pinpass" placeholder="Introduzca su numero pin" 
                         min=0001 max=9999 title="Pin de 4 dígitos" required>
                        <span class="iconClass-inside icon-key icon-left"></span>
                    </div>
                    <input type="button" class="btn-danger logout"  value="Cancelar" >
                </form>
            </section>
		</div>
		<?php include URL_TEMPLATES . 'login_footer.php'?>
	</body>
</html>