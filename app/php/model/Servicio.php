<?php 

require_once('../dao/UsuarioClienteDao.php');
require_once('../dao/ServicioDao.php');

class Servicio {
	
	private $iId;
	private $sDescripcion;
	private $iActivo;
	private $iIdPaquete;

	function __construct()
	{
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

	function __construct1($json){
		$array_servicio = json_decode($json);		
		foreach ($array_servicio as $field => $value) {						
			$SetProperty = 'Set'.substr($field, 1);
			$array_value[0] = $value;
			if (method_exists($this, $SetProperty)) {
				call_user_func_array(array($this,$SetProperty), $array_value);
			}
		}
	}

	public function GetId(){ return $this->iId; }
	public function SetId($value){ $this->iId = $value; }

	public function GetDescripcion(){ return $this->sDescripcion; }
	public function SetDescripcion($value){ $this->sDescripcion = $value; }

	public function GetActivo(){ return $this->iActivo; }
	public function SetActivo($value){ $this->iActivo = $value; }

	public function GetIdPaquete(){ return $this->iIdPaquete; }
	public function SetIdPaquete($value){ $this->iIdPaquete = $value; }


	//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }

	 //------------------------------------------------------------------------

	 public function ListarServiciosPaquetesActivos(){
	 	$servicioDao = new ServicioDao();
	 	return $servicioDao->ListarServiciosPaquetesActivos();
	 }

	 public function ListarServiciosByIdSolicitud($iIdSolicitud){
	 	$servicioDao = new ServicioDao();
	 	return $servicioDao->ListarServiciosByIdSolicitud($iIdSolicitud);
	 }

	 public function ListarServiciosDePaquetesParaEditarSolicitud($iIdSolicitud){

	 	$servicioDao = new ServicioDao();
	 	return $servicioDao->ListarServiciosDePaquetesParaEditarSolicitud($iIdSolicitud);

	 }




	
}

 ?>