<?php 

	include_once("../rest/InformacionRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarInformacionServicioPersona':
			
			$data = $request->datos;

			$informacionRestHandler = new InformacionRestHandler();
			$informacionRestHandler->ListarInformacionServicioPersona($data->iIdPersona, $data->iIdServicio);
			
			break;

		case 'IngresarInformacionServicioPersona':

			$data = $request->datos;

			$informacionRestHandler = new InformacionRestHandler();
			$informacionRestHandler->IngresarInformacionServicioPersona($data->iIdSolicitudDetalle, $data->iExiste, $data->iIdPersona, $data->iIdServicio, $data->detalle);

			break;

		
	}

 ?>