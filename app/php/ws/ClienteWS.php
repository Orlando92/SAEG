<?php 

	include_once("../rest/ClienteRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		
		case 'ListarCantidadSolicitudesClientes':

			$clienteRestHandler = new ClienteRestHandler();
			$clienteRestHandler->ListarCantidadSolicitudesClientes();
			
			break;

		case 'ListarClientesActivos':

			$clienteRestHandler = new ClienteRestHandler();
			$clienteRestHandler->ListarClientesActivos();
			
			break;

		
	}

 ?>