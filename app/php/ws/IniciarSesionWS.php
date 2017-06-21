<?php  
	
	include_once("../rest/IniciarSesionRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	$data = $request->datos;

	//echo $data;

	switch ($funcion) {

		case 'ValidarUsuario':
			
			$usuario = $data->usuario; 

			$password = $data->password;

			$iniciarSesionRestHandler = new IniciarSesionRestHandler();

			$iniciarSesionRestHandler->ValidarUsuario($usuario,$password);

			break;
		
		default:
			# code...
			break;
	}


?>