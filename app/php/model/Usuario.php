<?php
	require_once("../model/Persona.php");
	require_once("../interface/IUsuario.php");
	require_once("../dao/UsuarioDao.php");

	class Usuario extends Persona implements IUsuario, JsonSerializable{
		
		protected $sCorreo;
		protected $sPassword;
		protected $iIdTipoUsuario;
		protected $iActivo;

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

		function __contruct0(){}

		function  __construct2($sCorreo, $sPassword){
			$this->sCorreo = $sCorreo;
			$this->sPassword = $sPassword;
		}

		function __construct8($iId, $sApellidoPaterno, $sApellidoMaterno, 
				$sNombres, $sDni, $sCorreo, $sPassword, $iIdTipoUsuario){
			parent::__construct5($iId, $sApellidoPaterno, $sApellidoMaterno, $sNombres, $sDni);
			$this->sCorreo = $sCorreo;
			$this->sPassword = $sPassword;
			$this->iIdTipoUsuario = $iIdTipoUsuario;		
		}


		//--------------------------------------------------------------------------
		public function GetCorreo(){ return $this->sCorreo; }

		public function SetCorreo($value=''){ $this->sCorreo = $value; }

		public function GetPassword(){ return $this->sPassword; }

		public function SetPassword($value){ $this->sPassword = $value; }

		public function GetIdTipoUsuario(){ return $this->iIdTipoUsuario; }

		public function SetIdTipoUsuario($value){ $this->iIdTipoUsuario = $value; }

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

 	public function deserealizarUsuario($usuarioJson){
	 	$array_usuario = json_decode($usuarioJson);		
		foreach ($array_usuario as $field => $value) {						
			$SetProperty = 'Set'.substr($field, 1);
			$array_value[0] = $value;
			if (method_exists($this, $SetProperty)) {
				call_user_func_array(array($this,$SetProperty), $array_value);
			}
		}
	 }

		//--------------------------------------------------------------------------

		public function GetUsuarioValidacion(){
			$usuarioDao = new UsuarioDao();
			return $usuarioDao->GetUsuarioValidacion($this->sCorreo, $this->sPassword);
		}

		public function CambiarPassword($passwordActual, $passwordNueva){

			$usuarioDao = new UsuarioDao();

			return $usuarioDao->CambiarPassword($this->GetCorreo(), $passwordActual, $passwordNueva);
		}



	}

