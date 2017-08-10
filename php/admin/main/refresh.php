<?php 
header('Content-Type: application/json');
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/config.controller.php');

if($conn->row('SELECT * FROM user_reg ') >   0){
    include $_SERVER['DOCUMENT_ROOT'].'/php/admin/main/lbl.class.php';
    foreach ($conn->result as $value ){
        switch ($value['status']){
            case 0 : //cita borrada
                $data['status'] = 0 ;
                $data['idCita'] = $value['idCita'] ;
                break ;
            case 1 : //cita creada
                $conn2 = new connect\Conexion('bd_' . $_SESSION['bd']) ; 
                $sql = "SELECT D.idCita, A.Id AS idCodigo, A.codigo, D.agenda, D.idUsuario, U.nombre, D.obs, D.hora , D.fecha ,A.tiempo, A.descripcion
                    FROM cita C JOIN data D ON C.idCita = D.idCita 
                    INNER JOIN usuarios	U ON D.idUsuario = U.Id 
                    LEFT JOIN articulos A ON C.Servicio = A.Id  
                    WHERE D.idCita = " . $value['idCita'] . "
                    ORDER BY D.idCita, D.hora";

                $datos=$conn2->all($sql,MYSQLI_ASSOC);
                if ($num = count($datos)>0) {

                    for( $i = 0 ; $i < $num ; $i++ ){

                        if (!isset($datosagenda)){
                            $datosagenda = array(
                                'idCita'=>$datos[$i]['idCita'],
                                'fecha'=>$datos[$i]['fecha'],
                                'hora'=>$datos[$i]['hora'],
                                'agenda'=>$datos[$i]['agenda'],
                                'obs'=>$datos[$i]['obs'],
                                'idUsuario'=>$datos[$i]['idUsuario'],
                                'nombre'=>$datos[$i]['nombre'],
                                'servicios' => array()
                            );

                        }
                            $datosagenda['servicios'][] = array(
                                'idCodigo'=>$datos[$i]['idCodigo'],
                                'codigo'=>$datos[$i]['codigo'],
                                'des'=>$datos[$i]['descripcion'],
                                'tiempo'=> $datos[$i]['tiempo']
                            );
                         		foreach($datosagenda as $value){
                                    $fecha =  str_replace('-', '', trim($value['fecha'])) ;
                                    $agenda = $value['agenda'];
                                    $hora = strtotime($value['hora']);
                                    $arr_data[$fecha][$agenda][$hora] = $value;
                            }
                        
                    
                    }
   
                    //RESET TABLA CITA_USER
                    //$conn2->query("TRUNCATE user_reg");

                    $lbl = new main\Lbl( $datosagenda ) ;
                    $data['html'] = $lbl->paint(); 
                    echo $data['html'] ;
                    unset( $datosagenda );

                } 

                break ;
            case 2 : //cita editada
                $data['status'] = 2 ;
                break ;
            case 3 : // usuario editado
                $data['status'] = 3 ;
                break ;
            case 4 : // usuario borrado
                $data['status'] = 4 ;
                break ;
        }
    }
}

//echo json_encode($data);