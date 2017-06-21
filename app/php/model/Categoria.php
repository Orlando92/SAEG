<?php  

	require_once('../interface/ICategoria.php');
	require_once('../dao/CategoriaDao.php');

	class Categoria implements ICategoria, JsonSerializable{

		private $iId;
		private $sDescripcion;

		//------------------------------------------------------

		function __construct()
		{
			$params = func_get_args();
			$num_params = func_num_args();
			$funcion_constructor ='__construct'.$num_params;
			if (method_exists($this,$funcion_constructor)) {
				call_user_func_array(array($this,$funcion_constructor),$params);
			}
		}

		//------------------------------------------------------------------------

		function __construct1($iId){

			$this->iId = $iId;

		}

		//-------------------------------------------------------

		public function SetId($iId){$this->iId = $iId;}
		public function GetId(){return $this->iId;}
		public function SetDescripcion($sDescripcion){$this->sDescripcion = $sDescripcion;}
		public function GetDescripcion(){return $this->sDescripcion ;}
		
		//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//---------------------------------------------------------

		public function GetCategoriaById(){

			$categoriaDao = new CategoriaDao();

			return $categoriaDao -> GetCategoriaById($this->iId);

		}



	}

?>