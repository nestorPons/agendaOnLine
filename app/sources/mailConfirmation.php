<!DOCTYPE html>
<?php

    $User = $args[1]; 
    $date = $args[2][0];
    $hour = $args[2][1];
    $time = $args[2][2];   

    $interval = new \DateInterval('PT'.$time.'M');
    $d= \DateTime::createFromFormat('Y-m-d H:i',$date .' '. $hour);
    $start = $d->format('Ymd\THis'); 

    $d->add($interval);
    $end = $d->format('Ymd\THis'); 

    $hrefCalendar = $User->isGmail()
        ?$User->createUrlEventCalendarGoogle($date, $hour, $time )
        :\core\Tools::strToUrl("https://www.reservatucita.com/sources/ics.php?tile=".CONFIG['nombre_empresa']."&description=Tiene%20una%20cita%20&datestart=$start&dateend=$end&adress=".CONFIG['dir']);
?>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mensaje de cita aceptada</title>
    </head>
    <body background="cid:background-image" style="background-color:<?=CONFIG['color_main']?>" >
    <center>
        <div  style="padding:10px; width:320px; background-color:#fff; border-radius:<?=CONFIG['border_radio'].'px'?>" > 
            
            <p><img src="cid:logo" alt="logo" width=128px /></p>
        
                <h1 style="color:#48c188"><?=ucwords(NAME_EMPRESA)?></h1>
                <h3>Cita guardada con éxito</h3>
                <p>Su cita ha sido reservada para el el día:</p>
                <h3> <?= $date ?> a las <?=$hour?> h.</h3>
                <p>Tiempo total del servicio: <?= $time?> min.</p>
                <p>
                    <a href="<?=$hrefCalendar?>">
                        <img src="cid:btn" alt="Guardar cita en calendario">
                    </a>
                </p>
                   
                <p>Gracias por usar nuestro servicio de reserva OnLine.</a>            
        </div>
    </center>
    </body>
</html>