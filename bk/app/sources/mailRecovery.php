<?php 
    $link = URL_ABSOLUT . CODE_EMPRESA . '/recovery/' . $args[1];
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
        <div  style="padding:10px; width=360px"> 
            
            <p><img src="cid:logoimg" width=128px /></p>
            <h1 style="color:#48c188">Reestablecer contraseña</h1>
            <p>Ha solicitado reestablecer la contraseña de su cuenta en <?=NAME_EMPRESA?> .</p>
            <p>Le administramos un numero de identificación para validara la operación</p>
            <a href="<?=$link?>">Reestablecer contraseña</a>
            <p>o copiando esta dirección en su navegador</p>
            <p><?=$link?></p>
        
        </div>
    </center>
    </body>
</html>