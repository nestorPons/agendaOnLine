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

session_write_close(); //Cerramos la session para que ejecute otras peticiones 
set_time_limit(0);
$timestamp = date('Y-m-d H:i:s'); 
// Clase  que hara la busqueda del los registros actualizados  
$Logs = new models\Logs(); 
$n = 0;  
/**
 * Bucle que espera la obtencion de datos actualizados 
 * Debera de ser reiniciado cada hora
 */ 
while ($n < 60) {
    
    $result = $Logs->getByTime($timestamp);
    /**
     * Si obtenemos datos 
     * Buscamos los reguistros que han sido guardados 
     * si no esperamos un minuto y volvemos a realizar la consulta 
     * 
     */
    sleep(5);
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
        break;
    } else {
        $n++; 
        continue;
    }
}

header('Content-Type: application/json');
echo json_encode($data??false);
 