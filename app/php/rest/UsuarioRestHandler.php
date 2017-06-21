<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/UsuarioCtrl.php');

	class UsuarioRestHandler extends SimpleRest{

		public function CambiarPassword($passwordActual, $passwordNueva){

			$usuarioCtrl = new UsuarioCtrl();

			$dataJson = $usuarioCtrl->CambiarPassword($passwordActual, $passwordNueva);

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