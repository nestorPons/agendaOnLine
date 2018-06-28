<?php namespace models;

class Horarios extends \core\BaseClass {

	public $horas_array  ;
	public $close_hours ;
	public $uniTime = 0 ;
	private $horary; 
	
	public function __construct( ){
		
		parent::__construct('horarios');

	 }
	public function consult($sql){

		$arrhorarios = $this->conn->all($sql,MYSQLI_ASSOC);

		foreach ($arrhorarios as $key => $value){
			$horarios[] = [
				'id' => $value['id'] , 
				'agenda' => $value['agenda'] ,
				'dia_inicio' => $value['dia_inicio'], 
				'dia_fin' => $value['dia_fin'], 
				'hora_inicio' => $value['hora_inicio'] , 
				'hora_fin' => $value['hora_fin'] 
			];
		}

		return $horarios??false;
	 }

	public function horarios(){
	  return $this->consult("SELECT * FROM horarios ORDER BY dia_inicio");
	 }

	public function hours($day = 'all', $agenda = 0){

  		$sql =  ($day=='all') ?
			"SELECT * FROM horarios ORDER BY dia_inicio" :
			"SELECT * FROM horarios WHERE agenda = $agenda 
			AND $day BETWEEN dia_inicio AND dia_fin ORDER BY hora_inicio" ;
 
		if ($rows = $this->consult($sql)){
			foreach ($rows as $row){
				for($d = 0; $d <= 6; $d++){
					if ($d >= $row['dia_inicio'] && $d <= $row['dia_fin']){
						for($h=strtotime($row['hora_inicio']); $h<strtotime($row['hora_fin']) ; $h=strtotime("+15 minutes", ($h))){	
							$this->horary[$d][$row['agenda']][] = date('H:i', $h);
						}
					}
				}
			}
		}

		return $this->horary??false;
	
	 }
	public function initialize($agenda){
		$this->sql = "INSERT INTO horarios (`agenda`, `dia_inicio`, `dia_fin`, `hora_inicio`, `hora_fin`)
            VALUES ($agenda, 1 , 5, '9:00:00','20:00:00'), ($agenda, 6, 6, '9:00:00','14:00:00');";
		return $this->query($this->sql);
	 }

	public function add ( $datos ){
		
		$sql = "INSERT INTO horarios (agenda,dia,inicio,fin) 
		VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[2].")";
		
		return $this->query($sql) ;
	 }

	public function del_horarios($arr_id){
		$sql = '';
		foreach ($arr_id as $id){
			$sql .= 'DELETE FROM horarios WHERE id = '. $id . ';';
		}
		return $this->conn->multi_query($sql);
	 }	
	public function cls_status($hour, $arr_hours){

		//return to class
		$str_h =  $hour . ':00';
		
		$this->uniTime = (array_key_exists( $str_h , $arr_hours)===false)
		?  $this->uniTime 
		: ceil($arr_hours[$str_h] / 15) ;

		$return = $this->uniTime;

		$this->uniTime != 0 ? $this->uniTime -= 1 : 0 ;

		return  $return;
	 }	
	public function set_arr_busy($arr_hours){
		foreach($arr_hours as $key => $val){
			echo $key; 
			$arr[] = $key; 
		}		
		return $arr; 
	}
	public function out_time($hour, $date, $minTime){
		$date = $date . ' ' . $hour;
		$date = date('Ymd H:i',strtotime($date));

		return (strtotime("+".$minTime." minutes now")  > strtotime($date));

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
