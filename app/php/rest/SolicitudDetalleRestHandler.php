<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/SolicitudDetalleCtrl.php');

	class SolicitudDetalleRestHandler extends SimpleRest{

		public function ListarServiciosByIdSolicitud($iIdSolicitud){

			$solicitudDetalleCtrl = new SolicitudDetalleCtrl();
			$dataJson = $solicitudDetalleCtrl->ListarServiciosByIdSolicitud($iIdSolicitud);

			$this->responder($dataJson);
		}

	}


?>