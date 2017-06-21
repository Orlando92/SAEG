<?php  

	include_once("../rest/SolicitudDetalleRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarServiciosByIdSolicitud':

			$data = $request->datos;

			$solicitudDetalleRestHandler = new SolicitudDetalleRestHandler();
			$solicitudDetalleRestHandler->ListarServiciosByIdSolicitud($data->iIdSolicitud);
			
			break;
		
	}

?>