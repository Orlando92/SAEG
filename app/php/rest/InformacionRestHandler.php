<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/InformacionCtrl.php');

	class InformacionRestHandler extends SimpleRest{

		public function ListarInformacionServicioPersona($iIdPersona, $iIdServicio){

			$informacionCtrl = new InformacionCtrl(); 

			$dataJson = $informacionCtrl->ListarInformacionServicioPersona($iIdPersona, $iIdServicio);

			$this->responder($dataJson);
		}

		public function IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio, $detalle){

			$informacionCtrl = new InformacionCtrl(); 

			$dataJson = $informacionCtrl->IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio, $detalle);

			$this->responder($dataJson);
		}
	}

 ?>