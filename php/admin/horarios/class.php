<?php namespace horarios;

class Horarios{
		private $conn;
		public $horas_array;
		
		public function __construct( ){
			$this->conn = new \connect\Conexion( 'bd_' . $_SESSION['bd'] );
		}
		
		public function consult(){

			$arrHorarios = $this->conn->all("SELECT * FROM horarios ORDER BY dia",MYSQLI_ASSOC);

			foreach ($arrHorarios as $key => $value){
				$horarios[] = ['agenda' => $value['agenda'] ,'dia' => $value['dia'], 'inicio' => $value['inicio'] , 'fin' => $value['fin'] ];
			}

			return $horarios;
		}
		
		public function hours(){

			$row =  $this->consult()  ;

			foreach ($row as $key => $value){
				$inicio_horarios[$value['dia']][] = $value['inicio'];
				$fin_horarios[$value['dia']][] = $value['fin'];
			}

			for ($d = 0 ; $d <= 6 ;$d++ ){
				if (!empty($inicio_horarios[$d])){
					for ($i = 0 ; $i < count($inicio_horarios[$d]); $i++){
						for($h =  strtotime($inicio_horarios[$d][$i]); $h <=  strtotime($fin_horarios[$d][$i]) ; $h += strtotime("+15 minutes", strtotime($h))){	
							$horas_array[$d][] = date('H:i', $h);
						} 
					}
				}else{
					$horas_array[$d][] = null;
				}
			}			
			return $horas_array;
		
		}

		public function add($datos){
			
			$sql = "INSERT INTO horarios (agenda,dia,inicio,fin) 
			VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[2].")";
			
			return $this->query($sql) ;
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