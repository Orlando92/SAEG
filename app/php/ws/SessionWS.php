<?php  

	include_once("../rest/SessionRestHandler.php");

	$postdata = file_get_contents("php://input");

	if (!isset($postdata)) {
		echo 'error';	
	}	

	$request = json_decode($postdata);

	$funcion = $request->funcion;

	switch ($funcion) {
		case 'IsLogged':
			
			$sessionRestHandler = new SessionRestHandler();
			$sessionRestHandler->IsLogged();

			break;
		case 'DestroySession':
			
			$sessionRestHandler = new SessionRestHandler();
			$sessionRestHandler->DestroySession();

			break;

		case 'GetObjectSession':
			$sessionRestHandler = new SessionRestHandler();
			$data = $request->datos;
			$objectName = $data->objectName;
			$sessionRestHandler->GetObjectSession($objectName);
			break;

		case 'EsModuloAutorizado':
			$sessionRestHandler = new SessionRestHandler();
			$data = $request->datos;
			$sDescripcion = $data->sDescripcion;
			$sessionRestHandler->EsModuloAutorizado($sDescripcion);
			break;
		default:
			echo 'error';
			break;
	}

?>