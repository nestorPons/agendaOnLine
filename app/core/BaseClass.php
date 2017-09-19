<?php namespace core ;
class BaseClass{

    public $conn ;
    public $type = MYSQLI_ASSOC ;
    public $names ;
    public $multi_query = false; 
    private $table, $db, $sql = ''; 
    
    public function __construct($table , $bd = null) {
        $this->table = (string)$table ;
        $this->conn = new Conexion($bd);

    }
    public function getConnect () {
        return $this->conn ;
    }
    public function db () {
        return $this->db ; 
    }
    private function query(){
        $sql = $this->sql;
        $this->sql = '';
        return $this->conn->query($sql) ;
    }
    public function getAll ( string $columns = '*' , $type = MYSQLI_NUM ) {

        $query = $this->conn->query("SELECT $columns FROM {$this->table} ORDER BY id ASC") ;

       return $query->fetch_all( $type );
        
    }
    public function getById ( int $id , string $columns = '*'   ) {

       $sql = "SELECT $columns FROM {$this->table} WHERE id = $id LIMIT 1" ;
       $query = $this->conn->query($sql) ;

       return ($row = $query->fetch_assoc()) ? $row : false ;
    
    }
    public function getBy ( string $column , $value , $type = MYSQLI_ASSOC ) {

        $value = $this->conn->scape($value) ;
        $sql = "SELECT * FROM {$this->table} WHERE $column = '".(string)$value."'" ;
        $query = $this->conn->query($sql) ;
        $result = $query->fetch_all( $type )  ; 
             
        return $result ; 
    }
    public function getOneBy ( $column , $value , $type = 'assoc' ) {

        $value = $this->conn->scape($value) ;
        $sql = "SELECT * FROM {$this->table} WHERE $column = '$value' LIMIT 1 " ;
        $query = $this->conn->query($sql) ;

        return $type == 'assoc' ? $query->fetch_assoc( )  : $query->fetch_num( ) ; 
    }
    public function multi_query(){

        $r = $this->conn->multi_query($this->sql);
        $this->sql = '';
        $this->multi_query = false;
        return $r;
    }
    public function saveByID ( int $id , array $args = null  ) {

        $columns = '' ; 
        $values = '' ;

        if ( $id < 1 ) {

            foreach ($args as $column => $value ) {
                $columns .=  $column . ',' ;
                $values .= '"' . $value . '",' ; 
            }
            $columns = trim( $columns , ',' ) ;
            $values = trim( "'" . $values , "'," ) ;
            $this->sql .= "INSERT INTO {$this->table} ( $columns ) VALUES ( $values );" ;

        } else {
            $str = ''; 
            foreach ($args as $column => $value ) {
                $str .=  $column . ' ="' . $value . '",' ; 
            }

            $str = trim( $str , ',') ; 
            $this->sql .= "UPDATE {$this->table} SET $str WHERE id = $id;" ;
        }

        if(!$this->multi_query)
            return $this->query();
    }
    public function deleteById ( $id ) {
        $this->sql .= "DELETE FROM {$this->table} WHERE id =  $id ; ";

         if(!$this->multi_query)
            return $this->query();
    }
    public function deleteBy ( $column , $value ) {
        $this->sql .= "DELETE FROM {$this->table} WHERE $column = $value;";
           
         if(!$this->multi_query)
           return $this->query();
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
}