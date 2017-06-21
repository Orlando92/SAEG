<?php  

	require_once('../model/Paquete.php');



	/**
	* 
	*/
	class PaqueteCtrl
	{

		public function ListarPaquetesActivos(){
			$paquete = new Paquete();
			return $paquete->ListarPaquetesActivos();
		}

		
	}

?>