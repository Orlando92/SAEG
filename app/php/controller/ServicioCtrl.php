<?php 
	require_once("../model/Servicio.php");

	class ServicioCtrl{

		public function ListarServiciosActivos(){
			$servicio = new Servicio();
			return $servicio->ListarServiciosActivos();
		}

		public function ListarServiciosActivosByIdPaquete($iIdPaquete){
			$servicio = new Servicio();
			$servicio->SetIdPaquete($iIdPaquete);
			return $servicio->ListarServiciosActivosByIdPaquete();
		}

		
	}
 ?>