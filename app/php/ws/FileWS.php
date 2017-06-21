<?php
	include_once("../rest/SolicitudRestHandler.php");
	$archivo = $_FILES['file'];
	$codigo_solicitud = $_POST['codigo'];
	$funcion = $_POST['funcion'];

	if (!isset($_POST)) {
		echo 'error';
	}

	$data = array('success' => false);


	switch ($funcion) {

		case 'uploadFileInformeToUrl':

			$nombre_archivo = 'i-'.$codigo_solicitud.'.pdf';
			$path = $_SERVER['DOCUMENT_ROOT'].'/app/ant/archivos/informes/'.$nombre_archivo;

			if(copy($archivo['tmp_name'], $path)){

				$solicitudRestHandler = new SolicitudRestHandler();

				$resultado = $solicitudRestHandler->ActualizarInforme($codigo_solicitud, $nombre_archivo);

				$data = array('success' => $resultado);
			}



			break;


		case 'uploadFileAnexoToUrl':

			$nombre_archivo = 'a-'.$codigo_solicitud.'.pdf';
			$path = $_SERVER['DOCUMENT_ROOT'].'/app/ant/archivos/anexos/'.$nombre_archivo;

			if(copy($archivo['tmp_name'], $path)){

				$solicitudRestHandler = new SolicitudRestHandler();

				$resultado = $solicitudRestHandler->ActualizarAnexo($codigo_solicitud, $nombre_archivo);

				$data = array('success' => $resultado);
			}

			break;
	}

	print_r(json_encode($data));
?>
