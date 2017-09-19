<?php

if (isset($_GET['arg']))
    echo $error['tile'] ;
else
    include ( URL_VIEWS . 'error.php' ) ;