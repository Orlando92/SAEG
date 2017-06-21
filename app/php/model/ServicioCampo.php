<?php 
	
	require_once("../dao/ServicioCampoDao.php");

	class ServicioCampo  implements JsonSerializable{

		private $iId;
		private $sDescripcion;
		private $iIdServicio;

		public function GetId(){ return $this->iId; }
		public function SetId($value){ $this->iId = $value; }

		public function GetDescripcion(){ return $this->sDescripcion; }
		public function SetDescripcion($value){ $this->sDescripcion = $value;}

		public function GetIdServicio(){ return $this->iIdServicio; }
		public function SetIdServicio($value){ $this->iIdServicio = $value; }

			//-------------------------------------------------------------------------

		public function jsonSerialize() {
			$varsClase = get_class_vars(get_class($this));

			foreach ($varsClase as $key => $value) {
				$vars[$key] = $this->$key;
			}

			return $vars;
		}

		//-----------------------------------------------------------------------------

		public function ListarServicioCampos(){

			$servicioCampoDao = new ServicioCampoDao(); 

			return $servicioCampoDao->ListarServicioCampos($this->iIdServicio);

		}



}

 ?>