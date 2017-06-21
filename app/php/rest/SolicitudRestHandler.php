<?php

	include_once('../rest/SimpleRest.php');
	include_once('../controller/SolicitudCtrl.php');
	include_once('../model/Persona.php');

	class SolicitudRestHandler extends SimpleRest{

		public function ListarSolicitudesPendientes(){

			$solicitudCtrl = new SolicitudCtrl();

			$dataJson = $solicitudCtrl->ListarSolicitudesPendientes();

			if (is_null($dataJson)) {
				$statusCode = 404;
			}else{
				$statusCode = 200;
			}



			$this ->setHttpHeaders($statusCode);
			print_r($dataJson);



		}

		public function ListarSolicitudDetalleParaEditar($iIdSolicitud){

			$solicitudCtrl = new SolicitudCtrl();

			$data =  $solicitudCtrl-> ListarSolicitudDetalleParaEditar($iIdSolicitud);

			$dataJson = json_encode($data);

			$this->responder($dataJson);

		}

		public function ListarSolicitudDetalleParaRegistrar(){

			$solicitudCtrl = new SolicitudCtrl();

			$data =  $solicitudCtrl-> ListarSolicitudDetalleParaRegistrar();

			$dataJson = json_encode($data);

			$this->responder($dataJson);

		}

		public function CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios){

			$solicitudCtrl = new SolicitudCtrl();

			$data =  $solicitudCtrl->CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios);

			$dataJson = json_encode($data);

			$this->responder($dataJson);
		}

		public function EditarSolicitud($iIdSolicitud,$persona, $iIdPaqueteInclusivo, $servicios){

			$solicitudCtrl = new SolicitudCtrl();

			$data =  $solicitudCtrl->EditarSolicitud($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios);

			$dataJson = json_encode($data);

			$this->responder($dataJson);
		}

		public function ListarSolicitudesPorResponder(){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ListarSolicitudesPorResponder();

			$dataJson = json_encode($data);

			$this->responder($data);
		}

		public function EliminarSolicitud($iIdSolicitud){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->EliminarSolicitud($iIdSolicitud);

			$dataJson = json_encode($data);

			$this->responder($dataJson);

		}

		public function CrearSolicitudMasivo($solicitudes){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->CrearSolicitudMasivo($solicitudes);

			$dataJson = json_encode($data);

			$this->responder($dataJson);

		}

		public function ListarSolicitudesRespondidas($sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ListarSolicitudesRespondidas($sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);

			$this->responder($data);

		}

		public function ActualizarInforme($iIdSolicitud, $sInforme){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ActualizarInforme($iIdSolicitud, $sInforme);

			return $data;

		}

		public function ActualizarAnexo($iIdSolicitud, $sInforme){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ActualizarAnexo($iIdSolicitud, $sInforme);

			return $data;
		}

		public function ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);

			$this->responder($data);

		}

		public function ListarDatosSolicitud($iIdSolicitud){

			$solicitudCtrl = new SolicitudCtrl(); 

			$data = $solicitudCtrl->ListarDatosSolicitud($iIdSolicitud);

			$this->responder($data);

		}

	}

?>
