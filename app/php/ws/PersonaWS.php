<?php 

	include_once("../rest/PersonaRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarPersonaByDni':
			
			$data = $request->datos;

			$personaRestHandler = new PersonaRestHandler();
			$personaRestHandler->ListarPersonaByDni($data->dni);
			
			break;

		
	}

 ?>