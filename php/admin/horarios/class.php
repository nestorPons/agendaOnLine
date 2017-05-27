<?php namespace horarios;
class Horarios{
		private $conn;
		public $horas_array;
		
		public function __construct(){
			require('../../connect/conexion.php');
			$this->conn = conexion(false);
		}

		public function view(){
			$sql = "SELECT * FROM horarios";
			$row = mysqli_fetch_all(mysqli_query($this->conn,$sql),MYSQLI_ASSOC);

			foreach ($row as $key => $value){
				$inicio_horarios[$value['dia']][] = $value['inicio'];
				$fin_horarios[$value['dia']][] = $value['fin'];
			}
			strtotime("+15 minutes", strtotime($inicio_horarios[1	][1]));


			for ($d = 0 ; $d <= 6 ;$d++ ){
				if (!empty($inicio_horarios[$d])){
					for ($i = 0 ; $i < count($inicio_horarios[$d]); $i++){
						for($h =  strtotime($inicio_horarios[$d][$i]); $h <=  strtotime($fin_horarios[$d][$i]) ; $h += strtotime("+15 minutes", strtotime($h))){	
							$this->horas_array[$d][] = date('H:i', $h);
						} 
					}
				}
			}
			return $this->horas_array;
		}
		
		public function add($datos){
			$sql = "INSERT INTO horarios (agenda,dia,inicio,fin) 
			VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[2].")";
			
			return  (mysqli_query($this->conn,$sql)) 
		}
		
		public function del(){
			
		}
		
		public function edit(){
			
		}
		
		public function ajax($action){
			header('Content-Type: application/json');
				
			echo json_encode($row);
		}
}
$h = new Horarios;