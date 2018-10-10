
<section id="recover">
    <h1 class="heading">Recuperar contraseña</h1>
    <hr>
    <form id="frmRecover">
        <input type="hidden" id="empresa"  value="<?php  ?>">
        <p>Introduzca su email</p>
        <div class="iconClass-container icon-left">
            <input type="email" class="email" name="email" id="email" placeholder="Introduzca email." required>
            <span class="iconClass-inside icon-mail-1"></span>
        </div>
            <button type="submit" class="btn-success btnLoad " data-value="Enviar">Enviar</button>
            <input type="button" class="btn-danger inicio cancel " value="Cancelar" >
    </form>
</section>
