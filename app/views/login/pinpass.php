<?php
    include URL_TEMPLATES . '/header.php' ;
	$url_validate= URL_ABSOLUT . NAME_EMPRESA .'/'. 'validar';

	?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=NAME_EMPRESA?>" class="<?=CLASS_BACKGROUND?>" >
		<div id="login" class="login login-form ">
            <section id="pinpass">
                <h1 class="heading">Introduzca pin</h1>
                <hr>
                <form id="frmPinpass" method="post" action='<?= $url_validate ?>' defaultbutton="Entrar" >
                    <input type="hidden" id="empresa"  value="<?php  ?>">
                    <div class="iconClass-container icon-left">
                        <input type="number" class="pin" id="pinpass"  name="pinpass" placeholder="Introduzca su numero pin" 
                         min=0001 max=9999 title="Pin de 4 dígitos" required>
                        <span class="iconClass-inside icon-key"></span>
                    </div>
                    <p class= "submit">
                        <button type="submit" class="btn-success btnLoad" data-value="Aceptar">Aceptar</button>
                        <input type="button" class="btn-danger logout"  value="Cancelar" >
                    </p>
                </form>
            </section>
		</div>
		<footer class="login about">
			<p class="about-author">
				&copy; 2016 <a href="https://www.agendaonline.es" target="_blank">agendaOnLine v2.1</a>
				Creado por Néstor Pons
				<a href="contacto.html" target="_blank">Contacto</a>
			</p>			
		</footer>
	</body>
</html>