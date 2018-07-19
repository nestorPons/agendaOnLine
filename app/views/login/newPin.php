<?php
    include URL_TEMPLATES . '/header.php' ;
	$url_validate= '/'. CODE_EMPRESA .'/'. 'newPin.php';
?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=CODE_EMPRESA?>" class="<?=CLASS_BACKGROUND?>" >
		<div id="login" class="login login-form ">
            <section id="newpinpass">
                <h1 class="heading">Registro nuevo pin</h1>
                <hr>
                <h4>Ha seleccionado iniciar sesión con pin.</h4>
                <p  class="info">Introduzca un numero pin de 4 digitos que podra usar para iniciar la sesion.</p>
                <hr>
                <form id="frmPinpass" method="POST" action='<?= $url_validate ?>' defaultbutton="Entrar" >
                    <input type="hidden" name="empresa"  value="<?= CODE_EMPRESA  ?>">
                    <input type="hidden" name="controller"  value="newPin">
                    <input type="hidden" name="action"  value="save">
                    <div class="iconClass-container">
                        <span class="caption">Nuevo numero Pin</span>
                        <input type="number" class="pin" id="newpinpass"  name="newpinpass" placeholder="Introduzca su numero pin" 
                         min=0001 max=9999 title="Pin de 4 dígitos" required>
                        <span class="iconClass-inside icon-key icon-left"></span>
                    </div>
                    <div class="iconClass-container">
                        <span class="caption">Repita el numero Pin</span>
                        <input type="number" class="pin" id="newpinpass"  name="newpinpass" placeholder="Introduzca su numero pin" 
                         min=0001 max=9999 title="Pin de 4 dígitos" required>
                        <span class="iconClass-inside icon-key icon-left"></span>
                    </div>
                    <button class="btn-success btnLoad"  id="btnAceptar" value="Aceptar" default>Aceptar</button>
                    <input type="button" class="btn-danger logout"  value="Cancelar" >
                </form>
            </section>
		</div>
		<footer class="login about">
			<p class="about-author">
				&copy; 2018 <a href="www.reservatucita.es" target="_blank">reservaTuCita v1.1</a>
				Creado por Néstor Pons
				<a href="contacto.html" target="_blank">Contacto</a>
			</p>			
		</footer>
	</body>
</html>