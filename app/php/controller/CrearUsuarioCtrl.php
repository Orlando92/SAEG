<?php  

	require_once("../model/UsuarioAdmin.php");
	require_once("../model/UsuarioCliente.php");
	require_once("../model/UsuarioOperacion.php");


	class CrearUsuarioCtrl{

		public function CrearUsuarioAdmin($usuarioAdmin){

			return $usuarioAdmin->CrearUsuarioAdmin();
		}

		public function CrearUsuarioOperacion($usuarioOperacion){
			
			return $usuarioOperacion->CrearUsuarioOperacion();
		}

	}

?>