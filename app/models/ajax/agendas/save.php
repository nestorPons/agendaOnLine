<?php
$chck = $_POST['chck']??0;
$return['success'] = true;

$len = count($_POST['id']) - 1; 
for ($i=0 ; $i <= $len ;$i++){
    $id = (int)$_POST['id'][$i];

    if($_POST['save'][$i]){

        if(is_array($Agendas->getById($id))){
    
            if(
                !$Agendas->saveById($id , [
                    'mostrar' => $_POST['chck'][$i],
                    'nombre' => ($_POST['nombre'][$i])??"agenda".$id
                ])
            ) 
            {
                $return['success'] = false; 
                break;
    
            }
    
        } else {
            $H = new \models\Horarios; 
            $return['success'] = ($Agendas->add(CONFIG['num_ag'], $_POST['nombre'][$i]))
                ?$H->initialize($Agendas->getId())
                : false ; 	
        }
    } else {
        if(!($return['success'] = $Agendas->del($id))) break;
    }
}
return $return; 