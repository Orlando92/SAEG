<?php  

	include_once('../rest/SimpleRest.php');
	include_once('../controller/IniciarSesionCtrl.php');

	class IniciarSesionRestHandler extends SimpleRest{

		public function ValidarUsuario($usuario, $password){

			$iniciarSesionCtrl = new IniciarSesionCtrl();
			$dataJson = $iniciarSesionCtrl->ValidarUsuario($usuario, $password);
			$this->responder($dataJson);
		} 

	}


?>