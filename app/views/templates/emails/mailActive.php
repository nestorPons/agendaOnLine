<?php 
    $token = $args[1];
    $link = URL_ABSOLUT . NAME_CODE . '/activate/' . $token;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <center>
        <div class="body" style="padding:10px; width=360px"> 
            
            <p><img src="cid:logoimg" width=128px /></p>
            <h1 style="color:#48c188">Activar cuenta</h1>
            <p>Actualmente ha se ha bloqueado la cuenta en <?=NAME_EMPRESA?> .</p>
            <p>Puede volver a activar la cuenta siguiendo en el siguiente link:</p>
            <a href="<?=$link?>">Activar cuenta</a>
            <p>o copiando esta dirección en su navegador</p>
            <p><?=$link?></p>
        </div>
        <div class="footer">
            
            <p>Si lo desea puede ponerse en contacto con el administrador </p>
            <a href="mailto:<?=ADMIN_EMAIL?>"><?=ADMIN_EMAIL?></p>
        
        </div>

    </center>
    </body>
</html>