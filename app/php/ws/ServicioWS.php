		<?php 

	include_once("../rest/ServicioRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarServiciosActivos':
			
			$servicioRestHandler = new ServicioRestHandler();
			$servicioRestHandler->ListarServiciosActivos();
			
			break;

		
		case 'ListarServiciosActivosByIdPaquete':

			$data = $request->datos;

			if (!isset($data)){
				echo null;
			}

			$iIdPaquete = $data->iIdPaquete;

			$servicioRestHandler = new ServicioRestHandler();
			
			$servicioRestHandler->ListarServiciosActivosByIdPaquete($iIdPaquete);
			
			break;

		
	}

 ?>