<?php	
	require_once('../model/Usuario.php');
	require_once('../interface/IUsuarioOperacion.php');
	require_once('../dao/UsuarioOperacionDao.php');

	class UsuarioOperacion extends Usuario implements IUsuarioOperacion, JsonSerializable{

		private $iIdSede;

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

		function __construct9($iId, $sApellidoPaterno, $sApellidoMaterno, 
				$sNombres, $sDni, $sCorreo, $sPassword, $iIdTipoUsuario, $iIdSede){
			parent::__construct8($iId, $sApellidoPaterno, $sApellidoMaterno, 
				$sNombres, $sDni, $sCorreo, $sPassword, $iIdTipoUsuario);
			$this->iIdSede	= $iIdSede;

		}

		//--------------------------------------------------------------------------
		
		public function GetIdSede(){ return $this->iIdSede; }	

		public function SetIdSede($value){ $this->iIdSede = $value; }

			//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }

		//--------------------------------------------------------------------------	

		public function GetIdSedeById(){

			$usuarioOperacionDao = new UsuarioOperacionDao();

			return $usuarioOperacionDao->GetIdSedeById($this->iId);

		}

		public function CrearUsuarioOperacion(){

			$usuarioOperacionDao = new UsuarioOperacionDao();

			return $usuarioOperacionDao->CrearUsuarioOperacion($this);

		}

	}

?>