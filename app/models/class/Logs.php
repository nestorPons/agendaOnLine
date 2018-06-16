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
    public function get(int $days){
        $end = date('Y-m-d H:m:s',strtotime ( '+1 hour' , strtotime(date('Y-m-d H:m:s'))));
        $ini = date('Y-m-d H:m:s',strtotime ( '-'. $days .' day' , strtotime($end)));

        return $this->getBetween('date', $ini, $end, 'ORDER BY id DESC'); 
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