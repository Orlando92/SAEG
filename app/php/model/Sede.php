<?php 

	require_once('../dao/SedeDao.php');

	class Sede  implements JsonSerializable{

		private $iId;
		private $sDescripcion;
		private $sDireccion;
		private $iActivo;

		//-------------------------------------------------------------------------

		function __construct()
		{
			$params = func_get_args();
			$num_params = func_num_args();
			$funcion_constructor ='__construct'.$num_params;
			if (method_exists($this,$funcion_constructor)) {
				call_user_func_array(array($this,$funcion_constructor),$params);
			}
		}

		//--------------------------------------------------------------------------

		function __contruct0(){
			
		}

		function __contruct1($iId){

			$this->iId = $iId;

		}

		//--------------------------------------------------------------------------

		public function GetId(){ return $this->iId; }

		public function SetId($value){ $this->iId = $value; }

		public function GetDescripcion(){ return $this->sDescripcion; }

		public function SetDescripcion($value){ $this->sDescripcion = $value; }

		public function GetDireccion(){ return $this->sDireccion; }

		public function SetDireccion($value){ $this->sDireccion = $value; }
		
		public function GetActivo(){ return $this->iActivo; }

		public function SetActivo($value){ $this->iActivo = $value; }

			//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//--------------------------------------------------------------------------

		public function GetSedeActivoById(){

			$sedeDao = new SedeDao();

			return $sedeDao -> GetSedeActivoById($this->iId);

		}

	}

 ?>