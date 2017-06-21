<?php 

require_once('../interface/IPersona.php');
require_once('../dao/PersonaDao.php');

class Persona implements IPersona, JsonSerializable{

	protected $iId;
	protected $sApellidoPaterno;
	protected $sApellidoMaterno;
	protected $sNombres;
	protected $sDni;

	//---------------------------------------------------------------------------------

	function __construct()
	{
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

	//------------------------------------------------------------------------------------

	function __construct1($json){
		$array_persona = json_decode($json);		
		foreach ($array_persona as $field => $value) {						
			$SetProperty = 'Set'.substr($field, 1);
			$array_value[0] = $value;
			if (method_exists($this, $SetProperty)) {
				call_user_func_array(array($this,$SetProperty), $array_value);
			}
		}
	}

	function __construct5($iId, $sApellidoPaterno, $sApellidoMaterno, $sNombres, $sDni){
		$this->iId = $iId; 
		$this->sApellidoPaterno = $sApellidoPaterno;
		$this->sApellidoMaterno = $sApellidoMaterno;
		$this->sNombres = $sNombres;
		$this->sDni = $sDni;
	}

	//----------------------------------------------------------------------------------

	public function GetId(){ return $this->iId; }

	public function SetId($value){ $this->iId = $value; }

	public function GetApellidoPaterno(){ return $this->sApellidoPaterno; }

	public function SetApellidoPaterno($value){ $this->sApellidoPaterno = $value; }

	public function GetApellidoMaterno(){ return $this->sApellidoMaterno; }

	public function SetApellidoMaterno($value){ $this->sApellidoMaterno = $value; }

	public function GetNombres(){ return $this->sNombres; }

	public function SetNombres($value){ $this->sNombres = $value; }	

	public function GetDni(){ return $this->sDni; }

	public function SetDni($value){ $this->sDni = $value; }

		//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }

	//----------------------------------------------------------------------------------

	public function AsignarClase($persona){		
		foreach ($persona as $field => $value) {						
			$SetProperty = 'Set'.substr($field, 1);
			$array_value[0] = $value;
			if (method_exists($this, $SetProperty)) {
				call_user_func_array(array($this,$SetProperty), $array_value);
			}
		}


	}

	public function GetNombreCompleto(){ 
		return $this->sApellidoPaterno.' '.$this->sApellidoMaterno.', '.$this->sNombres; 
	}

	public function CrearPersona(){ 

		$personaDao = new PersonaDao();

		return $personaDao->CrearPersona($this);

	}

	public function ListarPersonaByIdSolicitud($iIdSolicitud){
		$personaDao = new PersonaDao();
		return $personaDao->ListarPersonaByIdSolicitud($iIdSolicitud);
	}

	public function  ListarPersonaByDni(){
		$personaDao = new PersonaDao();
		return $personaDao-> ListarPersonaByDni($this->sDni);

	}

}
 ?>