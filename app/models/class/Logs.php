<?php namespace models;
 class Logs extends \core\BaseClass{
    
    public function __construct(){
        parent::__construct('logs');		 
	 }
    public function set(int $idUser, string $action, int $idFK = 0, bool $status = true, string $tables = null ){
       return self::saveById(-1,[
                'idFK'=>$idFK, 
                'date'=>\core\Tools::current_date(), 
                'idUser'=> $idUser, 
                'tables'=> $tables, 
                'action'=> self::formatAction($action), 
                'status' => $status 
            ]);
    }
    public function get($day){
        /*
        $end = date('Y-m-d H:m:s',strtotime ( '+1 hour' , strtotime(date('Y-m-d H:m:s'))));
        $ini = date('Y-m-d H:m:s',strtotime ( '-'. $days .' day' , strtotime($end)));
        */
        $ini = date('Y-m-d H:m:s',strtotime($day . '00:00:00'));
        $end = date('Y-m-d H:m:s',strtotime($day . '24:59:59'));
        $sql = "SELECT *, (SELECT nombre FROM usuarios u WHERE u.id = idUser) as nombre FROM `logs` 
        WHERE date BETWEEN '$ini' AND '$end' 
        ORDER BY id DESC;" ;
        return $this->conn->all($sql, MYSQLI_ASSOC);
      
    }
    private static function formatAction($arg){

        switch ($arg) {
            case SAVE:
                return 1; 
            case DEL:
                return 2; 
            case EDIT:
                return 3; 
            case 'login':
                return 4; 
            case 'logout':
                return 5;            
        }
    }
}