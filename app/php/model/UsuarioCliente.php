<?php 	
	require_once('../model/Usuario.php');
	require_once('../interface/IUsuarioCliente.php');
	require_once('../dao/UsuarioClienteDao.php');

	class UsuarioCliente extends Usuario implements IUsuarioCliente, JsonSerializable {
 
		private $iIdCliente;

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

		function __construct9($iId, $sApellidoPaterno, $sApellidoMaterno, 
				$sNombres, $sDni, $sCorreo, $sPassword, $iIdTipoUsuario, $iIdCliente){
			parent::__construct8($iId, $sApellidoPaterno, $sApellidoMaterno, 
				$sNombres, $sDni, $sCorreo, $sPassword, $iIdTipoUsuario);
			$this->iIdCliente = $iIdCliente;

		}

		//--------------------------------------------------------------------------

		public function GetIdCliente(){ return $this->iIdCliente; }

		public function SetIdCliente($value){ $this->iIdCliente = $value; }

			//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


		//--------------------------------------------------------------------------

		public function getIdClienteById(){

			$usuarioClienteDao = new UsuarioClienteDao();

			return $usuarioClienteDao->getIdClienteById($this->iId);

		}

	}

?>