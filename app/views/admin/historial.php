<?php 
   $len = count($results);
?>
<div id="<?= $_POST['fecha']?>" class="dia">
    <h1 id="tituloHistorial">Historial</h1>
    <h4 id="totalRegistrosHistorial">Total registros: <?= $len?></h4>
    <div class="cuerpo">   
        
        <table class = "tablas colorear-filas">
            <thead>
                <tr>
                    <th class="id">Id</th>
                    <th class="icono">Ico</th>
                    <th class="fecha">Fecha</th>
                    <th class="accion">Acción</th>
                    <th class="idUsuario">Usuario</th>
                </tr>	
            </thead>
            <tbody>
                <tr id="" class ="template">
                    <td class="id"></td>
                    <td class="icono"><a class= "" ></a></td>
                    <td class="fecha"></td>
                    <td class="accion"></td>
                    <td class="idUsuario"></td>  
                </tr>

                <?php
    
                    for($i = 0; $i < $len ; $i++){
                        $r = $results[$i];
                        $id = $r['id'];
                        $date = $r['date'];
                        $user = $r['nombre'];
                        $table = $r['tables'];
                        $action = $r['action'];
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
                        include URL_TEMPLATES . 'row.historial.php';
                    }   
                ?>
            </tbody>
        </table>
    </div>
</div>
<scirpt src="js/min/historial.js"></scirpt>