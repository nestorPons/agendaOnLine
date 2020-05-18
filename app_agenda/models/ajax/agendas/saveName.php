<?php
    $action = EDIT; 
    $return['success'] = $Agendas->saveById($_POST['id'] , $_POST );
    return $return;