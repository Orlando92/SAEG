<?php 

	include_once("../rest/UsuarioRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'CambiarPassword':
			
			$data = $request->datos;

			$personaRestHandler = new UsuarioRestHandler();
			$personaRestHandler->CambiarPassword($data->passwordActual, $data->passwordNueva);
			
			break;		
	}

 ?>