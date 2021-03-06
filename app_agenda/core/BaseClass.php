<?php namespace core ;
class BaseClass{

    public 
        $names,
        $type = MYSQLI_ASSOC,
        $multi_query = false,
        $sql = ''; 

    protected
        $conn, 
        $table;  

    private 
        $db , 
        $log = false, 
        $return = false,  
        $logs = ['data','usuarios'];
    /**
     * Constructor
     *
     * @param string $table la tabla que se quiere consultar
     * @param string $db por defecto coge el nombre de  la base datos de un archivo de configuracion global
     * @param int $user usuario para realizar las consultas 3 niveles de usuario con distintos privilegios
     */
    public function __construct(string $table , string $db = NAME_DB, int $user = 0 ) {
        $this->table = $table ;        
        $this->conn = new Conexion($db, $user);
     }

    public function getConnect () {
        return $this->conn ;
     }
    public function db () {
        return $this->db ; 
     }
    public function query(){
        $sql = $this->sql;
        $this->sql = '';
        
        return $this->conn->query($sql);
     }
    public function getAll ( string $return = '*' , $type = MYSQLI_NUM , String $order = '') {
        $filter = empty($order)?'':'ORDER BY '.$order;
        $query = $this->conn->query("SELECT $return FROM {$this->table} " . $filter ) ;
        return $query->fetch_all( $type );
     }
    public function getById ( int $id , string $return = '*') {

        $sql = "SELECT $return FROM `{$this->table}` WHERE id = $id LIMIT 1" ;
        $query = $this->conn->query($sql) ;
        $result = ($row = $query->fetch_assoc()) ? $row : false ;
        return  $this->format($result);
    
     }  
    public function getBy ( $column , $value , string $return = '*', $type = MYSQLI_ASSOC, string $filter = '') {
        //varios valores ponerlos en un array
        $filters = '';

        if ( gettype($column) == 'array' )  {
            $count = count($column);
            for ($i = 0 ; $i < $count ; $i++){ 
                //$value[$i] = $this->conn->scape($value[$i]);   
                $filters .= ($i!=0) ? ' AND ' : '' ;
                $filters .= (string)$column[$i] ." = '".(string)$value[$i] ."'";
            }  
        } else {
            $value = $this->conn->scape($value) ;
            $filters = (string)$column ." = '".(string)$value ."'";  
        }
        $sql = "SELECT $return FROM {$this->table} WHERE $filters $filter;";
        $query = $this->conn->query($sql);
        $result = $query->fetch_all($type); 


        if ($return != '*' && count(explode(',', $return)) <= 1)
            $result = $this->converToArray($result);
        /*/
        }else if (count($result) == 1) {
            $result = $result[0];
        }
        */
        return $result ; 
     }
    public function getBySQL ( string $sql , $type = MYSQLI_ASSOC ) {

        $sql = "SELECT * FROM {$this->table} WHERE " . $sql;
        $query = $this->conn->query($sql);
        $result = $query->fetch_all($type); 
             
        return $result; 
     }
    public function getId () {
        return $this->conn->id();
     }
    public function getOneBy ( $column, $value, string $return = '*', $typeNum = false, $desc = false) {
        $order = $desc?'ORDER BY "id" DESC':'';

        $value = $this->conn->scape($value) ;
        $sql = "SELECT $return FROM {$this->table} WHERE $column = '$value' $order LIMIT 1  ;" ;
        $query = $this->conn->query($sql) ;

       if ($return != '*'){
            $result = $query->fetch_row();
            if(!empty($result) && count($result)<=1)$result = $result[0];
        }else{
            $result = $typeNum? $query->fetch_row(): $query->fetch_assoc() ; 
        }          
        
        return $result;
     }
    public function getRowById ( $value ){
        $sql = "SELECT * FROM {$this->table} WHERE id = '$value' " ;
        return $this->conn->row($sql) ;
     }
    public function getRowBy ( $column , $value ){
        $sql = "SELECT * FROM {$this->table} WHERE $column = '$value' " ;
        return $this->conn->row($sql) ;
     }
    public function getBetween ( String $column, String $val1, String $val2, String $args = '' ){
        $sql = "SELECT * FROM {$this->table} WHERE $column BETWEEN '$val1' AND '$val2' $args;" ;
        return $this->conn->all($sql) ;
     }
    public function count() {
        $sql = "SELECT * FROM {$this->table};";
        $result = $this->conn->num($sql);      
        return (int)$result;
     }
    public function multi_query(){

        $r = $this->conn->multi_query($this->sql);
        $this->sql = '';
        $this->multi_query = false;
        return $r;
     }
    public function saveById ( int $id ,$args = null, string $execption_sanitize = null ) {
        $columns = null ; 
        $values = null ;
        $args = $this->sanitize($args); 
        if ( $id == -1) {
            unset($args['id']);
            if (!is_null($args) && is_array($args)){
               foreach ($args as $column => $value ) {
                    $columns .=  $column . ',' ;
                    $values .= '"' . $value . '",' ; 
                }    
            }

            $columns = trim( $columns , ',' ) ;
            $values = trim( "'" . $values , "'," ) ;
            $this->sql .= "INSERT INTO {$this->table} ( $columns ) VALUES ( $values );" ;

        } else {

            $this->sql .= $this->updateSql($args , $id);
        }
      if(!$this->multi_query){
            $this->return = $this->query();
            return $this->return;
      }
     }
    public function saveBy(array $filter , array $args){
        $columns = "";
        $values ="";
        $fName = key($filter);
        $fValue = $filter[$fName];
        
        $args = $this->sanitize($args); 

        foreach ($args as $column => $value ) {
            $columns .=  $column . ',' ;
            $values .= '"' . $value . '",' ; 
         } 
        $columns = trim( $columns , ',' ) ;
        $values = trim( "'" . $values , "'," ) ;
        if ($id = $this->getOneBy($fName , $fValue, 'id')) 
            $this->sql .= $this->updateSql($args , $id);
        else 
            $this->sql .= "INSERT INTO {$this->table} ( $columns ) VALUES ( $values );" ;

      if(!$this->multi_query){
            $this->return = $this->query();
            return $this->return;
       }
     }
    public function saveAll( array $args = null ){
        $this->sql .= $this->updateSql($args);

      if(!$this->multi_query){
            $this->return = $this->query();
            return $this->return;
       }
     }
    private function updateSql(array $args = null, int $id = null){

        $str = ''; 
        foreach ($args as $column => $value ) {
            $str .=  $column . ' ="' . $value . '",' ;
        }

        $str = trim( $str , ',') ; 
        $str .= (!is_null($id))?" WHERE id = $id":'';
        $sql = "UPDATE {$this->table} SET $str ;" ;

        return $sql;

     }
    public function deleteById ( $id ) {
        $this->sql .= "DELETE FROM {$this->table} WHERE id =  $id ; ";

      if(!$this->multi_query){
            $this->return = $this->query();
            return $this->return;
       }
     }
    public function deleteBy ( $column , $value ) {
        $this->sql .= "DELETE FROM {$this->table} WHERE $column = $value;";
           
      if(!$this->multi_query){
            $this->return = $this->query();
            return $this->return;
       }
     }
    public function copyTableById($target , $id  ){
        $cols = '';
        $sql = "SELECT * FROM {$this->table}";    
        $query = $this->conn->query($sql) ;

        $info = $query->fetch_fields();
        foreach ($info as $val) {
            $cols .= $val->name . ',' ;
        }
        $cols = trim($cols,',');
         
        $this->sql .= "INSERT INTO $target ($cols) SELECT $cols FROM {$this->table} WHERE id = $id;";
        if(!$this->multi_query)
           return $this->query();

     }
    public function copyTableBy($target , $column , $value ){
        $cols = '';
        $sql = "SELECT * FROM {$this->table};";
        
        $query = $this->conn->query($sql) ;
        $info = $query->fetch_fields();
        foreach ($info as $val) {
            $cols .= $val->name . ',' ;
        }
        $cols = trim($cols,',');
         
        $this->sql .= "INSERT INTO $target ($cols) SELECT $cols FROM {$this->table} WHERE $column = $value;";
        if(!$this->multi_query)
           return $this->query();
        
     }
    private function converToArray($multi){
        $array = array();
        foreach ($multi as $key => $value){
            $value = array_values($value);
            $array[] = $value[0] ;
        }
        return $array;
     }
    private function format($result){

        if (is_array($result) && count($result) == 1) {
            foreach ($result as $key => $value){
                $result = $value ;
            }
        }
        return $result;
     }
    private function sanitize($post){

        if (empty($post)) return false; 

        if(isset($post['controller'])) unset($post['controller']);
        if(isset($post['action']) && is_string($post['action'])) unset($post['action']);

        // combierto post a tipo de dato devuelto 
        foreach($post as $k => $v){
            if(!is_array($v)){
                if(!empty($v)){ 
                    if(!empty($v)){
                        if(strtolower($v)==='true'){
                            $post[$k] = true; 
                        } elseif(strtolower($v)==='false'){
                            $post[$k] = false; 
                        } elseif ( is_numeric ( $v )){
                            $post[$k] = (int)$v;
                        }
                    }
                }
            }else{
                /**
                 * Si el valor es una array
                */
                foreach($v as $key => $val){
                    if(strtolower($val)==='true'){
                        $post[$k][$key] = true; 
                    } elseif(strtolower($val)==='false'){
                        $post[$k][$key] = false; 
                    } elseif ( is_numeric ( $val )){
                        $post[$k][$key] = (int)$val;
                    }
                }
            }
        }
        return $post;
     }
}