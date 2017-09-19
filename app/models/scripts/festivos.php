<?php
$row = $conn->all("SELECT fecha FROM festivos") ;

$count =  count($row) ;

for ($i = 0 ; $i < $count ; $i++ ){

    $r = (is_array($row[$i]))?$row[$i][0]:$row[$i] ;

    $date =new DateTime($r);
    $date = date_format($date,"md");
    $data['festivos'][]=$date;	

}

return $data['festivos']??false;
