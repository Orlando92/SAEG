<?php  

	require_once("../model/Usuario.php");
	require_once("../model/UsuarioOperacion.php");
	require_once("../model/UsuarioCliente.php");
	require_once("../model/TipoUsuario.php");
	require_once("../model/Categoria.php");
	require_once("../model/Sede.php");
	require_once("../model/Acceso.php");
	require_once("../model/Cliente.php");
	require_once("../model/Modulo.php");



	class SessionCtrl
	{
		public function SetObjectToSession($objectName, $objectValue){
     		if(!isset($_SESSION)) 
		    { 		    
		        session_start(); 
		    } 

			$_SESSION[$objectName] = json_encode($objectValue);
		}

		public function IsLogged(){
     		if(!isset($_SESSION)) 
		    { 
		        session_start(); 
		    } 
			if (isset($_SESSION['usuario'])) {
			
				return json_encode(1);	
			}
			return json_encode(0);
		}

		public function GetObjectSession($objectName){
     		if(!isset($_SESSION)) 
		    { 
		        session_start(); 
		    } 
			if (isset($_SESSION[$objectName])) {				
				$objeto = $_SESSION[$objectName];				
				return $objeto;
			}
			return null;
		}

		public function DestroySession(){
		    session_start(); 		   

		    session_unset(); 

			session_destroy();			
		}		
	}

?>