<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/ClienteCtrl.php');

	class ClienteRestHandler extends SimpleRest{

		public function ListarCantidadSolicitudesClientes(){

			$clienteCtrl = new ClienteCtrl();

			$dataJson = $clienteCtrl->ListarCantidadSolicitudesClientes();

			if (empty($dataJson)) {
				$statusCode = 404;
			}else{
				$statusCode = 200;
			}
$this ->setHttpHeaders($statusCode);
			print_r($dataJson);

			
		
		}

		public function ListarClientesActivos(){

			$clienteCtrl = new ClienteCtrl();

			$dataJson = $clienteCtrl->ListarClientesActivos();

			if (empty($dataJson)) {
				$statusCode = 404;
			}else{
				$statusCode = 200;
			}
	$this ->setHttpHeaders($statusCode);
			print_r($dataJson);

		

		}
	}

 ?>