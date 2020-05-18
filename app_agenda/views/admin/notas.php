<?php 

$notas = $Notas->getBy("DATE_FORMAT (fecha, '%Y-%m-%d')",Date('Y-m-d')); 

foreach($notas as $nota){
    $fecha = str_replace('-','',$nota['fecha']) ;
    $h = new DateTime($nota['hora']); 
    $hora =  trim($h->format('H:m')); 
    $contenido = $nota['nota'];
    $id =  $nota['id'];
    include URL_TEMPLATES . 'row.notas.php';

}?>
<div id="nuevaNota">
    <i class="icon-plus"></i>
    <span class="tile">Nueva nota</span>
</div>