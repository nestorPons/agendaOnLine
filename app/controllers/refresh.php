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

//while (true) {
    
    $result = $Logs->getByTime($timestamp);
    var_dump($result);
    /**
     * Si obtenemos datos 
     * Buscamos los reguistros que han sido guardados 
     * si no esperamos un minuto y volvemos a realizar la consulta 
     * count($result)
     */
    if(true){
        $data[] = 'hola' ; 
        foreach($result as $key => $val){ 
            $Query =    new \core\BaseClass($val['tables']);
            $data[] = $Query->getById($val['idFK']); 
        }
 
       // $json = json_encode($result);
        header('Content-Type: application/json');
        echo json_encode(['MI'=>'123456']);
       // break;
    } else {
        sleep( 1 );
//        continue;
echo("FIN");
    }
//}
