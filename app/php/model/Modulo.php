<?php 

	require_once('../dao/ModuloDao.php');

	class Modulo implements JsonSerializable{

		private $iId;
		private $sDescripcion;
		private $iActivo;
		private $sRuta;
		private $sNombre;
		private $sIcono;

		//--------------------------------------------------------------------------

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

		function __construct0(){}

		function __construct1($iId){

			$this->iId = $iId;

		}

		//--------------------------------------------------------------------------

		public function GetId(){ return $this->iId; }

		public function SetId($value){ $this->iId = $value;	}

		public function GetDescripcion(){ return $this->sDescripcion; }

		public function SetDescripcion($value){ $this->sDescripcion = $value; }

		public function GetActivo(){ return $this->iActivo; }

		public function SetActivo($value){ $this->iActivo = $value; }

		public function GetRuta(){ return $this->sRuta; }

		public function SetRuta($value){ $this->sRuta = $value; }

		public function GetNombre(){ return $this->sNombre; }

		public function SetNombre($value){ $this->sNombre = $value; }

		public function GetIcono(){ return $this->sIcono; }

		public function SetIcono($value){ $this->sIcono = $value; }

			//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//--------------------------------------------------------------------------

		function GetModuloActivoById(){

			$moduloDao = new ModuloDao();

			return $moduloDao->getModuloActivoById($this->iId);

		}

	}

 ?>