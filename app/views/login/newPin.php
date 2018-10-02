	<body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
        <main id="login">
            <div class="login login-form ">
                <section id="newpinpass">
                    <h1 class="heading">Registro nuevo pin</h1>
                    <hr>
                    <h4>Introduzca un numero pin de 4 digitos que podra usar para iniciar futuras sesiones.</h4>
                    <hr>
                    <form id="frmPinpass" defaultbutton="Entrar" >
                        <input type="hidden" name="empresa"  value="<?= $Empresa->code()  ?>">
                        <input type="hidden" name="controller"  value="newPin">
                        <input type="hidden" name="action"  value="save">
                        <div class="iconClass-container">
                            <span class="caption">Nuevo numero pin 4 dígitos</span>
                            <input type="number" class="pin" id="newpinpass"  name="newpinpass" placeholder="Introduzca su numero pin" 
                            min=0001 max=9999 maxlength="4" title="Pin de 4 dígitos" required>
                            <span class="iconClass-inside icon-key icon-left"></span>
                        </div>
                        <button class="btn-success btnLoad"  id="btnAceptar" value="Aceptar" default>Aceptar</button>
                        <input type="button" class="btn-danger logout"  value="Cancelar" >
                    </form>
                </section>
            </div>
            <?php include URL_TEMPLATES . 'login_footer.php'?>
        </main>
	</body>
</html>
