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
AKI:: 
	public function all(){
	  $result=$this->consult("SELECT * FROM horarios ORDER BY dia_inicio");
		if ($result){
			foreach ($result as $row){
				for($d = 0; $d <= 6; $d++){
					if ($d >= $row['dia_inicio'] && $d <= $row['dia_fin'] ){
						for($h=strtotime($row['hora_inicio']); $h<strtotime($row['hora_fin']) ; $h=strtotime("+15 minutes", ($h))){	
							$this->horary[$d][$row['agenda']][] = date('H:i', $h);
						}
					}
				}
			}
		}
		return $this->horary; 
	 }

	public function hours($day = 'all', $agenda = 0){

  		$sql =  ($day=='all') ?
			"SELECT * FROM horarios ORDER BY dia_inicio AND agenda" :
			"SELECT * FROM horarios WHERE agenda = $agenda 
			AND $day BETWEEN dia_inicio AND dia_fin ORDER BY hora_inicio" ;
 
		if ($rows = $this->consult($sql)){
			foreach ($rows as $row){
				for($d = 0; $d <= 6; $d++){
					if ($d >= $row['dia_inicio'] && $d <= $row['dia_fin']){
						for($h=strtotime($row['hora_inicio']); $h<strtotime($row['hora_fin']) ; $h=strtotime("+15 minutes", ($h))){	
							$this->horary[$d][$agenda][] = date('H:i', $h);
						}
					}
				}
			}
		}

		return $this->horary??false;
	
	 }
	/*public function days($day){
		$row =  $this->consult("SELECT * FROM horarios WHERE dia = $day")  ;

		foreach ($row as $key => $value){
			$inicio_horarios[$value['dia']][] = $value['inicio'];
			$fin_horarios[$value['dia']][] = $value['fin'];
		}

	 }
	 */

	public function add ( $datos ){
		
		$sql = "INSERT INTO horarios (agenda,dia,inicio,fin) 
		VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[2].")";
		
		return $this->query($sql) ;
	 }
	public function save ( $data ) {
		$this->multi_query = false;

		foreach($data as $d )
			if(!$this->saveById($d['id'], $d)) return false; 
		
		return true;
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
