<?php 

	require_once('../dao/TipoUsuarioDao.php');

class TipoUsuario implements JsonSerializable{

	private $iId;
	private $sDescripcion;
	private $iIdCategoria;

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

	function __construct1($iId){

		$this->iId = $iId;

	}

	//--------------------------------------------------------------------------

	public function GetId(){ return $this->iId; }

	public function SetId($value){ $this->iId = $value; }

	public function GetDescripcion(){ return $this->sDescripcion; }

	public function SetDescripcion($value){ $this->sDescripcion = $value; }

	public function GetIdCategoria(){return $this->iIdCategoria;}

	public function SetIdCategoria($value){$this->iIdCategoria = $value;}

		//-------------------------------------------------------------------------

	 public function jsonSerialize() {

	 	$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }

	//--------------------------------------------------------------------------

	public function GetTipoUsuarioById(){

		$tipoUsuarioDao = new tipoUsuarioDao();

		return $tipoUsuarioDao->GetTipoUsuarioById($this->iId);

	}

}

 ?>