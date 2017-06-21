<?php  

	require_once("../model/Informacion.php");
	include_once("../controller/SessionCtrl.php");
	include_once("../controller/Control.php");
	
	class InformacionCtrl{

		public function ListarInformacionServicioPersona($iIdPersona, $iIdServicio){

			$informacion = new Informacion();

			return $informacion->ListarInformacionServicioPersona($iIdPersona, $iIdServicio);
		}

		public function IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio, $detalle){

			$informacion = new Informacion();

			$sessionCtrl = new SessionCtrl();

			$usuario =  $sessionCtrl->GetObjectSession('usuario');

			$usuario = json_decode($usuario);

			$iIdUsuario = Control::desencriptar($usuario->iId);

			return $informacion->IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio, $iIdUsuario, $detalle);
		}
	}

?>