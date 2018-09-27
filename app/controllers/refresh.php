<?php 
/**
 * long polling
 * Un bucle infinito
 * Obtenemos la marca de tiempo que se hizo la peticion ss
 * Y realizamos continuas consultas cada minuto a la espera 
 * de que se hayan actualizado los datos en la tabla logs 
 * si en una hora no se ha actualizado nada paramos el bucle y esperamos una nueva peticion probocada por el usuario
 */
// Quitamos el limite de tiempo que tenemos en php.ini

$date = new DateTime();
$date->modify('-1 minute');
$timestamp = $date->format('d-m-Y H:i:s');
// Clase  que hara la busqueda del los registros actualizados  
$Logs = new models\Logs();  
/**
 * Bucle que espera la obtencion de datos actualizados 
 * Debera de ser reiniciado cada hora
 */ 
    
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
        // Si es la cita esta formada por dos tablas data y cita
        if ($val['tables'] == 'data') {
            // Extraigo datos de cita
            // SOLO PARA DATA 
            $Cita =  new models\Cita($val['idFK']); 

            if ($Cita->exist()){
                $data[$val['tables']][] = array_merge(
                    $Cita->data(), 
                    [
                        'action'=>$val['action'], 
                        'table'=>$val['tables']
                    ]);
            } else {
                    $data[$val['tables']][] =    
                    [   
                        'idCita'=>$val['idFK'], 
                        'action'=>$val['action'], 
                        'table'=>$val['tables']
                    ];
            }

        } else { 
            // Flujo normal de la actualizaciones 
            $data[$val['tables']][] =array_merge(
                $Query->getById($val['idFK']), 
                [
                    'action'=>$val['action'], 
                    'table'=>$val['tables']
                ]
            );
        }
    } 
} 


header('Content-Type: application/json');
echo json_encode($data??false);
 