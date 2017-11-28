<?php namespace models;

class Horarios extends \core\BaseClass {

	public $horas_array  ;
	public $close_hours ;
	public $uniTime = 0 ;
	
	private $table = 'horarios' ;
	
	public function __construct( ){
		
		parent::__construct($this->table);

	}
	public function consult($sql){

		$arrhorarios = $this->conn->all($sql,MYSQLI_ASSOC);

		foreach ($arrhorarios as $key => $value){
			$horarios[] = ['id' => $value['id'] , 'agenda' => $value['agenda'] ,'dia' => $value['dia'], 'inicio' => $value['inicio'] , 'fin' => $value['fin'] ];
		}

		return $horarios??false;
	}
	public function all(){
		return $this->consult("SELECT * FROM horarios ORDER BY dia") ;  
	}
	public function hours($day = 'all'){

		$sql =  ($day=='all') ?
			"SELECT * FROM horarios ORDER BY dia " :
			"SELECT * FROM horarios WHERE dia = $day ORDER BY inicio " ;

		if ($row = $this->consult($sql)){
			foreach ($row as $value){
				$inicio_horarios[$value['dia']][] = $value['inicio'];
				$fin_horarios[$value['dia']][] = $value['fin'];
			}
	
			for ($d = 0 ; $d <= 6 ;$d++ ){
				if (!empty($inicio_horarios[$d])){
					for ($i = 0 ; $i < count($inicio_horarios[$d]); $i++){
						for($h =  strtotime($inicio_horarios[$d][$i]); $h <=  strtotime($fin_horarios[$d][$i]) ; $h = strtotime("+15 minutes", ($h))){	
							$horas_array[$d][] = date('H:i', $h);	
							if ( $h ==  strtotime($fin_horarios[$d][$i] )) {
								$this->close_hours [$d][] = date('H:i', $h) ;
							}
						} 
					}
				}else{
					$horas_array[$d][] = null;
				}
			} 
		

		}	

		return $horas_array??false;
	
	}
	public function days($day){
		$row =  $this->consult("SELECT * FROM horarios WHERE dia = $day")  ;

		foreach ($row as $key => $value){
			$inicio_horarios[$value['dia']][] = $value['inicio'];
			$fin_horarios[$value['dia']][] = $value['fin'];
		}

	}
	public function add ( $datos ){
		
		$sql = "INSERT INTO horarios (agenda,dia,inicio,fin) 
		VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[2].")";
		
		return $this->query($sql) ;
	}
	public function save_horarios ( $data_arr ) {
		$sql = "" ;

		for($i = 0 ; $i < count($data_arr); $i++){
			$data = $data_arr[$i];	
			$data_ini = date('H:i:s' ,strtotime( $data['ini']));
			$data_fin = date('H:i:s' ,strtotime( $data['fin']));

			if($data['id']== -1){
				$sql .= 'INSERT INTO horarios (agenda, dia, inicio, fin) VALUES ('.$data['agenda'] . ', '.$data['dia'] . ', "'.$data_ini . '","'.$data_fin. '");';
			} else {
				$sql .= 'UPDATE horarios SET agenda='.$data['agenda'] . ', dia='.$data['dia'] . ',inicio= "'.$data_ini . '",fin="'.$data_fin . '" WHERE id=' . $data['id'] . ';';
			}
		}
		return $this->conn->multi_query($sql);
	}
	public function del_horarios($arr_id){
		$sql = '';
		foreach ($arr_id as $id){
			$sql .= 'DELETE FROM horarios WHERE id = '. $id . ';';
		}
		return $this->conn->multi_query($sql);
	}	
	public function cls_status($hour  , $arr_busy_hours , $exit_cls = 'busy'){
		//return to class
		$str_h =  $hour . ':00';
		
		$this->uniTime = (array_key_exists( $str_h , $arr_busy_hours)===false)
		?  $this->uniTime 
		: ceil($arr_busy_hours[$str_h] / 15) ;

		$cls = $this->uniTime  != 0 ? $exit_cls : '' ;

		$this->uniTime != 0 ? $this->uniTime -= 1 : 0 ;

		return  $cls;
	}	
	public function out_time($hour, $date, $minTime){

		$date = $date . ' ' . $hour;
		$date = date('Ymd H:i',strtotime($date . "+".$minTime." minutes"));
		return (strtotime("now") > strtotime($date));

	}
	public function cls_close($week_day) {
		//return to class
		return in_array($h , $this->close_hours[$week_day])?'cierre':'';
	}
	public function ajax($action){
		header('Content-Type: application/json');
			
		echo json_encode($row);
	}
}
