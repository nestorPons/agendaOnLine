<section id="newUser">
    <h1 class="heading">Registro nuevo usuario</h1>
    <hr>
    <form id="frmNewUSer">
        <input type="hidden" id="empresa"  value="<?php  ?>">
        <div class="iconClass-container icon-left">
            <input type="text" id="nombre" placeholder="Introduzca nombre y apellidos." required >	
            <span class="iconClass-inside icon-user-1"></span>
        </div>
        <div class="iconClass-container icon-left">
            <input type="email" class="email" name="email" id="email" placeholder="Introduzca email." required>
            <span class="iconClass-inside icon-mail-1"></span>
        </div>
        <div class="iconClass-container icon-left">
            <input type="tel" class="tel" name="tel" id="tel" title="Un numero telefono válido!!"	placeholder="Telefono de contacto" required>
            <span class="iconClass-inside icon-phone"></span>
        </div>
        <div class="iconClass-container icon-left">
            <input type="password" id="pass"  placeholder="Introduzca contraseña" required>
            <span class="iconClass-inside icon-eye"></span>
        </div>
            <input type="hidden" name="pass" id="pass">
        <div class="iconClass-container icon-left">
            <input type="password" id="passR"  placeholder="repita contraseña" required>
            <span class="iconClass-inside icon-eye"></span>
        </div>

        <button type="submit" class="btn-success btnLoad " id="btnSuccessNew" data-value="Guardar">Guardar</button>
        <input type="button" class="btn-danger inicio cancel" id="btnCancelNew" value="Cancelar" >

    </form>
</section>
<section id="secNewNotification" class="hidden">
    <h1 class="heading">Registro aceptado</h1>
    <hr>
    <p>Se le ha enviado un email a su cuenta asociada.</p>
    <p>Siga las instrucciones para activar la cuenta.</p>
    <p>Gracias</p>
</section>