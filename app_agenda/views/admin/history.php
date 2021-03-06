<?php 
   $len = count($results);
?>
<h1 id="tituloHistorial">Historial</h1>
<h4 id="totalRegistrosHistorial">Total registros: <?= $len?></h4>
<div class="cuerpo">   
    
    <table class = "tablas">
        <thead>
            <tr class="row">
                <th class="id">Id</th>
                <th class="icono">Ico</th>
                <th class="fecha">Fecha</th>
                <th class="accion">Acción</th>
                <th class="idUsuario">Usuario</th>
                <th class="estado">Est</th>
            </tr>	
        </thead>
        <tbody>
            <tr id="" class ="template">
                <td class="id"></td>
                <td class="icono"><a class= "" ></a></td>
                <td class="fecha"></td>
                <td class="accion"></td>
                <td class="idUsuario"></td>
                <td class="estado"></td>    
            </tr>

            <?php
 
                for($i = 0; $i < $len ; $i++){
                    $r = $results[$i];
                    $id = $r['id'];
                    $date = $r['date'];
                    $user = $r['nombre'];
                    $status = $r['status']?'Ok':'Error';
                    $table = $r['tables'];
                    $action = $r['action'];
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
                            $ico = 'login';    
                            $accion = "Entrada usuario";
                            break;
                        case 5:
                            $ico = 'logout';
                            $accion = "Salida usuario";
                            break;
                    }
                    include URL_TEMPLATES . 'row.history.php';
                }   
            ?>
        </tbody>
    </table>
</div>