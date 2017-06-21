<?php

require_once("../model/Persona.php");
require_once("../model/UsuarioCliente.php");
require_once("../dao/SolicitudDao.php");

class Solicitud  implements JsonSerializable
{
	private $iId;
	private $iIdPersona;
	private $iIdUsuarioCliente;
	private $dFechaPedido;
	private $dFechaInforme;

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

	//--------------------------------------------------------------------------

	function __construct1($iId)
	{
		$this->iId = $iId;
	}

	//------------------------------------------------------------------------

	public function GetId(){ return $this->iId; }

	public function SetId($value){ $this->iId = $value;	}

	public function GetIdPersona(){ return $this->iIdPersona; }

	public function SetIdPersona($value){ $this->iIdPersona = $value; }

	public function GetIdUsuarioCliente(){ return $this->iIdUsuarioCliente; }

	public function SetIdUsuarioCliente($value){ $this->iIdUsuarioCliente = $value;	}

	public function GetFechaPedido(){ return $this->dFechaPedido; }

	public function SetFechaPedido($value){ $this->dFechaPedido = $value; }

	public function GetFechaInforme(){ return $this->dFechaInforme; }

	public function SetFechaInforme($value){ $this->dFechaInforme = $value;	}

	//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


	//--------------------------------------------------------------------------

	public function CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios){
		$solicitudDao = new SolicitudDao();
		return $solicitudDao->CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios);
	}

	public function EditarSolicitud($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios){
		$solicitudDao = new SolicitudDao();
		return $solicitudDao->EditarSolicitud($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios);
	}

	public function ListarSolicitudesPendientes($iIdCliente){
		$solicitudDao = new SolicitudDao();
		return $solicitudDao->ListarSolicitudesPendientes($iIdCliente);
	}

	public function ListarSolicitudesPorResponder(){
		$solicitudDao = new SolicitudDao();
		return $solicitudDao->ListarSolicitudesPorResponder();
	}

	public function EliminarSolicitud(){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->EliminarSolicitud($this->GetId());
	}

	public function CrearSolicitudMasivo($iIdUsuario, $solicitudes){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->CrearSolicitudMasivo($iIdUsuario, $solicitudes);

	}

	public function ListarSolicitudesRespondidas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->ListarSolicitudesRespondidas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);

	}

	public function ActualizarInforme($iIdSolicitud, $sInforme){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->ActualizarInforme($iIdSolicitud, $sInforme);
	}

	public function ActualizarAnexo($iIdSolicitud, $sInforme){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->ActualizarAnexo($iIdSolicitud, $sInforme);
	}

	public function ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

		$solicitudDao = new SolicitudDao();

		return $solicitudDao->ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);

	}

	public function ListarDatosSolicitud(){

		$solicitudDao = new SolicitudDao(); 

		return $solicitudDao->ListarDatosSolicitud($this->iId);

	}

}

 ?>
