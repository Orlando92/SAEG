<?php 

	include_once("../rest/ServicioCampoRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarServicioCampos':
			
			$data = $request->datos;

			$servicioCampoRestHandler = new ServicioCampoRestHandler();
			$servicioCampoRestHandler->ListarServicioCampos($data->iIdServicio);
			
			break;

		
	}

 ?>