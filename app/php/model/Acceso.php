<?php 
	
	require_once('../dao/AccesoDao.php');

class Acceso implements JsonSerializable{

	private $iId;
	private $iIdTipoUsuario;
	private $iIdModulo;

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

	
	

	//--------------------------------------------------------------------------

	public function GetId(){ return $this->iId;	}

	public function SetId($value){ $this->iId = $value;	}

	public function GetIdTipoUsuario(){ return $this->iIdTipoUsuario; }

	public function SetIdTipoUsuario($value){ $this->iIdTipoUsuario = $value; }

	public function GetIdModulo(){ 	return $this->iIdModulo; }

	public function SetIdModulo($value){ $this->iIdModulo = $value;	}

	//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


	//--------------------------------------------------------------------------

	public function getAccesosByIdTipoUsuario(){

		$accesoDao = new AccesoDao();

		return $accesoDao->getAccesosByIdTipoUsuario($this->iIdTipoUsuario);

	}



}


 ?>