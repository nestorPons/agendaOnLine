<h1 id="tituloHistorial">Historial</h1>
<div class="cuerpo">
    <table class = "tablas">
        <thead>
            <tr>
                <th class="id">Id</th>
                <th class="icono">Icono</th>
                <th class="fecha">Fecha</th>
                <th class="idUsuario">Usuario</th>
                <th class="accion">Acción</th>
                <th class="estado">Estado</th>
            </tr>	
        </thead>
        <tbody>
            <tr id="" class ="template">
                <td class="id"><?=$id?></td>
                <td class="icono"><a class= "icon-<?=$ico?>" ></a></td>
                <td class="fecha"><?=$date?></td>
                <td class="idUsuario"><?=$user?></td>
                <td class="accion"><?=$accion?></td>
                <td class="estado"><?=$status?></td>    
            </tr>

            <?php 
                $len = count($results);
                for($i = 0; $i < $len ; $i++){
                    $r = $results[$i];
                    $id = $r[0];
                    $date = $r[1];
                    $user = $r[2];
                    $status = $r[5]?'Ok':'Error';
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