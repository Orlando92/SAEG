<?php  

	include_once('../rest/SimpleRest.php');
	include_once('../controller/SolicitudCtrl.php');

	class FileRestHandler extends SimpleRest{

		public function ActualizarInforme($iIdSolicitud, $sInforme){


			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ActualizarInforme($iIdSolicitud, $sInforme);

			return $data;

		}

		public function ActualizarAnexo($iIdSolicitud, $sInforme){

			$solicitudCtrl = new SolicitudCtrl();

			$data = $solicitudCtrl->ActualizarAnexo($iIdSolicitud, $sInforme);

			return $data;
		}

	}


?>