<?php 
	include URL_VIEWS . 'login/header.php' ;
?>
    <link rel="stylesheet" href="css/cube.css">
	<title>Agenda Online zona login</title>
	</head>
    <body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
        <section class="login login-cube">
            <div id="cube">
                <div id ="back" class="face"></div>
                <div id="left" class="face"></div>
                <div id="front" class="face">
                    <?php include URL_VIEWS . 'login/login.php'?>
                </div>
                <div id="right" class="face"></div>
            </div>
        </section>
        <!--//BLOQUE COOKIES-->
        <div id="barraaceptacion">
            <div class="inner">
                Solicitamos su permiso para obtener datos estadísticos de su navegación en esta web, en cumplimiento del Real 
                Decreto-ley 13/2012. Si continúa navegando consideramos que acepta el uso de cookies.
                <a href="javascript:void(0);" id="btnbarraaceptacion" class="ok"><b>ACEPTAR</b></a> | 
                <a href="/sources/politicCookies.php?empresa=<?=$Empresa->code()?>" target="_blank" class="info">Más información</a>
            </div>
        </div>
        <?php include URL_TEMPLATES . 'login_footer.php'?>
        <!--//FIN BLOQUE COOKIES-->
        <script src="js/cube.js"></script>
    </body>
</html>