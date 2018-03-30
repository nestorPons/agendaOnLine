<?php 
    $link = URL_ABSOLUT . CODE_EMPRESA . '/activate/' . $token;
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
            <h1 style="color:#48c188">Confirmación de nuevo usuario</h1>
            <p>Actualmente ha creado una nueva contraseña en <?=ucwords(NAME_EMPRESA)?> .</p>
            <p>Para finalizar debe activar la cuenta siguiendo en el siguiente link:</p>
            <a href="<?=$link?>">Activar cuenta</a>
            <p>o copiando esta dirección en su navegador</p>
            <p><?=$link?></p>
        
        </div>
    </center>
    </body>
</html>



