<section id="secLogin">
    <a href= "<?=CONFIG['web']??''?>"  target="_blank">
        <img id="logo" src="./<?=URL_LOGO?>" alt="logo image"/>
    </a>
    <h1 class="heading">Agenda <?=NAME_EMPRESA?></span></h1>
    <hr>
    <form id="loginUsuario" defaultbutton="Entrar"
        data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
        data-popover-background="bg-red" data-popover-color="fg-white">
        <div class="iconClass-container icon-left">
            <input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" 
            value="<?php if(isset($demo_email)){echo $demo_email;}?>" require>
            <i class="iconClass-inside icon-mail-1"></i>
        </div>
        <div class="iconClass-container icon-left">
            <input type="password" id="pass_login" placeholder="Introduzca su contraseña" value="<?php if(isset($demo_pass)){echo $demo_pass;}?>" require>
            <i class="iconClass-inside icon-eye"></i>
        </div>
        <div id="chkNoCerrarSesion">
            <input type="checkbox" id="recordar"  name="recordar" value="1" >
            <span class="info">Iniciar sesión con un pin.</span>
        </div>

        <button class="btn-success btnLoad"  id="btnLogin" value="Entrar"  disabled default>Entrar</button>

    </form>
    <div class="login-help">
        <p>
            ¿Olvidaste la contraseña?
            <a id="forgotPass">Pulsa aquí</a>.
        </p>
        <p>
            <a id="goNewUser">Crear nuevo usuario.</a>.
        </p>
    </div>
</section>