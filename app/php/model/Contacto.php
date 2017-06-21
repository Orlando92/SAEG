<?php  

	include_once('../model/Persona.php');
	include_once('../dao/ContactoDao.php');

	/**
	* 
	*/
	class Contacto extends Persona implements JsonSerializable
	{
		private $sEmail;
		private $sTelefono;

		//-------------------------------------------------------------

		function __construct()
		{
			$params = func_get_args();
			$num_params = func_num_args();
			$funcion_constructor ='__construct'.$num_params;
			if (method_exists($this,$funcion_constructor)) {
				call_user_func_array(array($this,$funcion_constructor),$params);
			}
		}

		//-------------------------------------------------------------




		//-------------------------------------------------------------

		public function GetEmail(){return $this->sEmail;}

		public function SetEmail($value){$this->sEmail = $value;}

		public function GetTelefono(){return $this->sTelefono;}

		public function Telefono($value){$this->sTelefono = $value;}

		//--------------------------------------------------------------	

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//----------------------------------------------------------------

		
		
	}

?>