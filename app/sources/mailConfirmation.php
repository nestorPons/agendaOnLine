<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mensaje de cita aceptada</title>
    </head>
    <body>
    <center>
        <div  style="padding:10px; width=360px"> 
            
            <p><img src="cid:logoimg" width=128px /></p>
        
                <h1 style="color:#48c188"><?=ucwords(NAME_EMPRESA)?></h1>
                <h2>Cita guardada con éxito</h2>


                <p>Su cita ha sido reservada para el el día:</p>
                <br>
                <h2> <?= $args[1][0] ?> a las <?= $args[1][1]?> h.</h2>
                <br>
                <p>Tiempo total del servicio: <?= $args[1][2]?> min.</p>
                <p>Gracias por usar nuestro servicio de reserva OnLine.</a>
                </p>
                <br>
                <p>Que tenga buen dia</p><br>	
                <div class="login-help">
                    <p><a href="<?= CONFIG['web']?>">Pagina web</a></p>
                </div>


        
        </div>
    </center>
    </body>
</html>