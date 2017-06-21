<?php  

	require_once("../model/Cliente.php");
	
	class ClienteCtrl{

		public function ListarCantidadSolicitudesClientes(){

			$cliente = new Cliente();

			return $cliente->ListarCantidadSolicitudesClientes();

		}

		public function ListarClientesActivos(){

			$cliente = new Cliente();

			return $cliente->ListarClientesActivos();

		}
	}

?>