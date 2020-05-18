<?php
if (isset($_POST['action'])) {

    $User = new models\User($_POST['id']);

    switch ($_POST['action']) {
        case SAVE:
            if (empty($_POST['email'])) unset($_POST['email']);
            $r['success'] = $User->save($_POST);
            $r['id'] = $User->getId();
            // crear historia
            $Logs->set($_SESSION['id_usuario'], $_POST['action'],  $r['id'], 'usuarios');

            break;

        case 'historial':
            $ini = new \DateTime('2000-07-01');
            $end = new \DateTime();
            $r['data'] = $User->history($ini, $end, $_POST['limit']);
            $r['success'] =  $r['data'] != null;
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($r);
} else {
    $Users = new core\BaseClass('usuarios');
    $users  = $Users->getAll('*', MYSQLI_ASSOC, 'nombre');

    \core\Tools::minifierJS($_POST['controller']);
    require_once URL_VIEWS_ADMIN . 'usuarios.php';
}
