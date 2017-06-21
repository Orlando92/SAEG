<?php

require_once("../model/Persona.php");
require_once("../model/UsuarioCliente.php");
require_once("../model/Cliente.php");
require_once("../model/Servicio.php");
require_once("../model/Paquete.php");
require_once("../model/Solicitud.php");
require_once("../model/SolicitudDetalle.php");
require_once("../model/Persona.php");
include_once("../controller/Control.php");
include_once("../controller/SessionCtrl.php");



class SolicitudCtrl{


	public function ListarSolicitudesPendientes(){


		$sessionCtrl = new SessionCtrl();

		$clienteJson = $sessionCtrl->GetObjectSession('cliente');

		$cliente = new Cliente();

		$cliente->deserealizarCliente($clienteJson);

		$solicitud = new Solicitud();

		return $solicitud->ListarSolicitudesPendientes($cliente->GetId());
	}

	public function ListarSolicitudDetalleParaEditar($iIdSolicitud){

		$persona = new Persona();

		$personaJson = $persona->ListarPersonaByIdSolicitud($iIdSolicitud);

		$paquete = new Paquete();

		$paquetes = $paquete->ListarPaquetesParaEditarSolicitud($iIdSolicitud);

		$servicio = new Servicio();

		$solicitudDetalle = array();

		array_push($solicitudDetalle,$personaJson);

		array_push($solicitudDetalle,$paquetes);

		$servicios = $servicio->ListarServiciosDePaquetesParaEditarSolicitud($iIdSolicitud);

		array_push($solicitudDetalle,$servicios);

		return $solicitudDetalle;

	}

	public function ListarSolicitudDetalleParaRegistrar(){

		$solicitudDetalle = array();

		$paquete = new Paquete();

		$paquetes = $paquete->ListarPaquetesActivos();

		array_push($solicitudDetalle,$paquetes);

		$servicio = new Servicio();

		$servicios = $servicio->ListarServiciosPaquetesActivos();

		array_push($solicitudDetalle,$servicios);

		return $solicitudDetalle;

	}

	public function CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios){

		$personaModel = new Persona();

		$personaModel->AsignarClase($persona);

		$solicitud = new Solicitud();

		$iIdUsuario = Control::desencriptar($iIdUsuario);

		return $solicitud->CrearSolicitud($personaModel, $iIdUsuario, $iIdPaqueteInclusivo, $servicios);
	}

	public function EditarSolicitud($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios){

		$solicitud = new Solicitud();

		$personaModel = new Persona();

		$personaModel->AsignarClase($persona);

		return $solicitud->EditarSolicitud($iIdSolicitud, $personaModel, $iIdPaqueteInclusivo, $servicios);
	}

	public function EliminarSolicitud($iIdSolicitud){

		$solicitud = new Solicitud($iIdSolicitud);

		return $solicitud->EliminarSolicitud();
	}

	public function ListarSolicitudesPorResponder(){

		$solicitud = new Solicitud();

		return $solicitud->ListarSolicitudesPorResponder();
	}

	public function CrearSolicitudMasivo($solicitudes){

		$sessionCtrl = new SessionCtrl();

		$usuario =  $sessionCtrl->GetObjectSession('usuario');

		$usuario = json_decode($usuario);

		$iIdUsuario = Control::desencriptar($usuario->iId);

		$solicitud = new Solicitud();

		$solicitudesXML = Control::generateValidXmlFromArray(json_decode($solicitudes));

		return $solicitud->CrearSolicitudMasivo($iIdUsuario, $solicitudesXML);

	}

	public function ListarSolicitudesRespondidas($sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

		$sessionCtrl = new SessionCtrl();

		//$cliente =  $sessionCtrl->GetObjectSession('cliente');
		$clienteJson = $sessionCtrl->GetObjectSession('cliente');
		//$cliente = json_decode($cliente);
		$cliente = new Cliente();
		$cliente->deserealizarCliente($clienteJson);

		//$iIdCliente =$cliente->iId;

		$solicitud = new Solicitud();

		return $solicitud->ListarSolicitudesRespondidas($cliente->GetId(), $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);
	}

	public function ActualizarInforme($iIdSolicitud, $sInforme){

		$solicitud = new Solicitud();

		return $solicitud->ActualizarInforme($iIdSolicitud, $sInforme);
	}

	public function ActualizarAnexo($iIdSolicitud, $sInforme){

		$solicitud = new Solicitud();

		return $solicitud->ActualizarAnexo($iIdSolicitud, $sInforme);
	}

	public function ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

		$solicitud = new Solicitud();

		return $solicitud->ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);
	}

	public function ListarDatosSolicitud($iIdSolicitud){

		$solicitud = new Solicitud(); 

		$solicitud->SetId($iIdSolicitud);

		return $solicitud->ListarDatosSolicitud();

	}
}


 ?>
