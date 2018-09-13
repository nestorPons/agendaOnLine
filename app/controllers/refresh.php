<?php 
/**
 * long polling
 * Un bucle infinito
 * Obtenemos la marca de tiempo que se hizo la peticion 
 * Y realizamos continuas consultas cada minuto a la espera 
 * de que se hayan actualizado los datos en la tabla logs 
 * si en una hora no se ha actualizado nada paramos el bucle y esperamos una nueva peticion probocada por el usuario
 */
// Quitamos el limite de tiempo que tenemos en php.ini

set_time_limit(0);
$timestamp = date('Y-m-d H:i:s', time()); 
// Clase  que hara la busqueda del los registros actualizados  
$Logs = new models\Logs(); 
$n = 0; 
/**
 * Bucle que espera la obtencion de datos actualizados 
 * Debera de ser reiniciado cada hora
 */ 
while ($n < (1000 * 60 * 60 )) {
    
    $result = $Logs->getByTime($timestamp);
    /**
     * Si obtenemos datos 
     * Buscamos los reguistros que han sido guardados 
     * si no esperamos un minuto y volvemos a realizar la consulta 
     * 
     */
    if(count($result)){
        foreach($result as $key => $val){ 
            $Query =  new \core\BaseClass($val['tables']);
            $data[] = $Query->getById($val['idFK']); 
        } 
        break;
    } else {
        sleep( 1 );
        $n++; 
        continue;
    }
}

$data = $data??'finish';  
header('Content-Type: application/json');
echo json_encode($data);