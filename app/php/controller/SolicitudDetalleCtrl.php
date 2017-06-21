<?php  
	
	require_once('../model/SolicitudDetalle.php');

	class SolicitudDetalleCtrl{

		public function ListarServiciosByIdSolicitud($iIdSolicitud){

			$solicitudDetalle = new SolicitudDetalle();
			$solicitudDetalle->SetIdSolicitud($iIdSolicitud);
			return $solicitudDetalle->ListarServiciosByIdSolicitud();

		}

	}

?>