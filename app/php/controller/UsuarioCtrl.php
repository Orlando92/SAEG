<?php  

	require_once("../model/Usuario.php");
	require_once("../controller/SessionCtrl.php");

	class UsuarioCtrl{

		public function CambiarPassword($passwordActual, $passwordNueva){

			$sessionCtrl = new SessionCtrl();

			$usuarioJson = $sessionCtrl->GetObjectSession('usuario');

			$usuario = new Usuario();

			$usuario->deserealizarUsuario($usuarioJson);

			return $usuario->CambiarPassword($passwordActual, $passwordNueva);

		}
	}

?>