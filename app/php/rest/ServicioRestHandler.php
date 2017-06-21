<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/ServicioCtrl.php');

	class ServicioRestHandler extends SimpleRest{

		public function ListarServiciosActivos(){

			$servicioCtrl = new ServicioCtrl();

			$dataJson = $servicioCtrl->ListarServiciosActivos();

			if (empty($dataJson)) {
				$statusCode = 404;
			}else{
				$statusCode = 200;
			}

			print_r($dataJson);

			$this ->setHttpHeaders($statusCode);



		}

		public function ListarServiciosActivosByIdPaquete($iIdPaquete){

			$servicioCtrl = new ServicioCtrl();

			$data = new $servicioCtrl->ListarServiciosActivosByIdPaquete($iIdPaquete);

			$dataJson = json_encode($data);

			$this->responder($dataJson);

		} 
		
	}

 ?>