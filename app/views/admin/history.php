<?php		
    $days = $_POST['days']??DEFAULT_HISTORY_DAYS; 
    $results =$Logs->get($days);
?>
<div class="cuerpo">
    <table class = "tablas">
        <thead>
            <tr>
                <th>Icono</th>
                <th>Fecha</th>
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
                    $id = $r[1];
                    $user = $r[2];
                    $date = $r[3];
                    $status = $r[4];
                    $table = $r[5];
                    $action = $r[6];
                    $colorClass = $status == 0 ? 'red' : 'green';
                    switch ($action){
                        case 1:
                            $ico = 'plus'; 
                            $strAc = "Nueva cita";
                            break;
                        case 2:
                            $ico = 'trash-empty';
                            $strAc = "Elimina cita";
                            break;
                       case 3:
                            $ico = 'edit';
                            $strAc = "Cita modificada";
                            break;
                        case 4:
                            $ico = 'login';    
                            $strAc = "Entra usuario";
                            break;
                        case 5:
                            $ico = 'logout';
                            $strAc = "Sale usuario";
                            break;
                    }
                    include URL_TEMPLATES . 'row.history.php';
                }   
            ?>
        </tbody>
    </table>
</div>