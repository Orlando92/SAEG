<?php

	include_once("../rest/SolicitudRestHandler.php");


	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {

		case 'ListarSolicitudesPendientes':

			$solicitudRestHandler = new SolicitudRestHandler();
			$solicitudRestHandler->ListarSolicitudesPendientes();

			break;

		case 'ListarSolicitudDetalleParaEditar':

			$data = $request->datos;

			$solicitudRestHandler = new SolicitudRestHandler();
			$solicitudRestHandler->ListarSolicitudDetalleParaEditar($data->iIdSolicitud);

			break;

		case 'ListarSolicitudDetalleParaRegistrar':

			$solicitudRestHandler = new SolicitudRestHandler();
			$solicitudRestHandler->ListarSolicitudDetalleParaRegistrar();

			break;

		case 'RegistrarSolicitudIndividual':

			$data = $request->datos;

			$lista = $data->lista;

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->CrearSolicitud($data->persona, $data->iIdUsuario, $lista->paqueteInclusivoSeleccionado, $lista->servicios);

			break;


		case 'EditarSolicitud':

			$data = $request->datos;

			$lista = $data->lista;

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->EditarSolicitud($data->iIdSolicitud, $data->persona, $lista->paqueteInclusivoSeleccionado, $lista->servicios);

			break;
		case 'ListarSolicitudesPorResponder':

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->ListarSolicitudesPorResponder();

			break;

		case 'EliminarSolicitud':

			$data = $request->datos;

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->EliminarSolicitud($data->iIdSolicitud);

			break;

		case 'CrearSolicitudMasivo':

			$data = $request->datos;

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->CrearSolicitudMasivo($data->solicitudes);

			break;


		case 'ListarSolicitudesRespondidas':

			$solicitudRestHandler = new SolicitudRestHandler();

			$data = $request->datos;

			$solicitudRestHandler->ListarSolicitudesRespondidas($data->sDni, $data->sNombres, $data->sApellidoPaterno, $data->sApellidoMaterno);


			break;

		case 'ListarSolicitudesHistoricas':

			$data = $request->datos;

			$solicitudRestHandler = new SolicitudRestHandler();

			$solicitudRestHandler->ListarSolicitudesHistoricas($data->IdCliente, $data->Dni, $data->Nombres, $data->ApellidoPaterno, $data->ApellidoMaterno);

			break;

		case 'ListarDatosSolicitud':

			$data = $request->datos;

			$solicitudRestHandler = new SolicitudRestHandler(); 

			$solicitudRestHandler->ListarDatosSolicitud($data->iIdSolicitud);

			break;

		default:
			# code...
			break;
	}

?>
