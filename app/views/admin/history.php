<?php		
    $days = $_POST['days']??DEFAULT_HISTORY_DAYS; 
    $results =$Logs->get($days);
    $accion = "null";
?>
<div class="cuerpo">
    <table class = "tablas">
        <thead>
            <tr>
                <th>Icono</th>
                <th class="dateTime">Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Estado</th>
                <th>Nº</th>
            </tr>	
        </thead>
        <tbody>
            <?php 
                $len = count($results);
                for($i = 0; $i < $len ; $i++){
                    $r = $results[$i];
                    $id = $r[0];
                    $date = $r[1];
                    $user = $r[2];
                    $status = $r[5];
                    $table = $r[6];
                    $action = $r[3];
                    $colorClass = $status == 0 ? 'red' : 'green';
                    switch ($action){
                        case 1:
                            $ico = 'plus'; 
                            $accion = "Nueva cita";
                            break;
                        case 2:
                            $ico = 'trash-empty';
                            $accion = "Cita eliminada";
                            break;
                       case 3:
                            $ico = 'edit';
                            $accion = "Cita modificada";
                            break;
                        case 4:
                            $ico = 'logout';
                            $accion = "Salida usuario";
                            break;
                        case 5:
                            $ico = 'login';    
                            $accion = "Entrada usuario";
                            break;
                    }
                    include URL_TEMPLATES . 'row.history.php';
                }   
            ?>
        </tbody>
    </table>
</div>