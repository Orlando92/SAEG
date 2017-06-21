<?php 

	require_once("../model/Usuario.php");
	require_once("../interface/IUsuarioAdmin.php");
	require_once("../dao/UsuarioAdminDao.php");

	class UsuarioAdmin extends Usuario implements IUsuarioAdmin, JsonSerializable{
		
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

		function __construct0(){}

			//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//--------------------------------------------------------------------------

		public function CrearUsuarioAdmin(){

			$usuarioAdminDao = new UsuarioAdminDao();

			return $usuarioAdminDao->CrearUsuarioAdmin($this);

		}

		

	}

 ?>