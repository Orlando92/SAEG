<?php 
	
	require_once("../controller/SessionCtrl.php");
	require_once("../controller/Control.php");	
	require_once("../model/Usuario.php");
	require_once("../model/UsuarioOperacion.php");
	require_once("../model/UsuarioCliente.php");
	require_once("../model/TipoUsuario.php");
	require_once("../model/Categoria.php");
	require_once("../model/Sede.php");
	require_once("../model/Acceso.php");
	require_once("../model/Cliente.php");
	require_once("../model/Modulo.php");
	/**
	* 
	*/
	class IniciarSesionCtrl
	{
		
		public function ValidarUsuario($usuario, $password){

			$sessionCtrl = new SessionCtrl();

			$usuario = new Usuario($usuario,$password);

			$usuario = $usuario->GetUsuarioValidacion();

			if (empty($usuario)) {

				$respuesta = -1; // Datos ingresados incorrectos 
				return $respuesta;
			}

			$tipoUsuario = new TipoUsuario($usuario->GetIdTipoUsuario());

			$acceso = new Acceso();

			$acceso->SetIdTipoUsuario($tipoUsuario->GetId());

			$accesos = $acceso->getAccesosByIdTipoUsuario();

			$modulos = array();

			
			foreach ($accesos as $objeto) {
				$modulo = new Modulo($objeto->getIdModulo());	
				$modulo = $modulo->GetModuloActivoById();
				array_push($modulos, $modulo);
			}

			if (empty($modulos)) {
				$respuesta = -2; // No existen modulos para el usuario ingresado
				return $respuesta;
			}
			
			if (count($modulos) == 0) {
				$respuesta = -2; // No existen modulos para el usuario ingresado
				return $respuesta;
			}

			$tipoUsuario = $tipoUsuario->GetTipoUsuarioById(); 

			$categoria = new Categoria($tipoUsuario->GetIdCategoria());

			$categoria = $categoria->GetCategoriaById();

		 	
			switch ($categoria->GetId()) {
				// Si es de Administracion 
				case 1:

					$usuario->SetId(Control::encriptar(strval($usuario->GetId())));

					$sessionCtrl->SetObjectToSession('usuario',$usuario);

					break;
				// Si es de Operacion 
				case 2:					
					$usuarioOperacion = new UsuarioOperacion($usuario->GetId(), $usuario->GetApellidoPaterno(), 
						$usuario->GetApellidoMaterno(),$usuario->GetNombres(), $usuario->GetDni(), $usuario->GetCorreo(), $usuario->GetPassword(), $usuario->GetIdTipoUsuario());

					$usuarioOperacion->SetIdSede($usuarioOperacion->GetIdSedeById());

					$usuarioOperacion->SetId(Control::encriptar(strval($usuarioOperacion->GetId())));

					$sede = new Sede();

					$sede->SetId($usuarioOperacion->GetIdSede());
					
					$sede = $sede->GetSedeActivoById();

					if (empty($sede)) {
						$respuesta = -3; // La sede no esta activa para el usuario
						return $respuesta;
					}

					$sessionCtrl->SetObjectToSession('usuario',$usuarioOperacion);

					$sessionCtrl->SetObjectToSession('sede',$sede);
					
					break;

				// Si es Cliente 
				case 3:
				//AQUI HACIAS REFERENCIA A LAS PROPIEDADES DEL OBJETO SIN UTILIZAR LAS FUNCIONES GET, EJEMPLO: $usuario->iId, $usuario->$sApellidoPaterno
					$usuarioCliente = new UsuarioCliente($usuario->GetId(), $usuario->GetApellidoPaterno(), 
						$usuario->GetApellidoMaterno(),$usuario->GetNombres(), $usuario->GetDni(), $usuario->GetCorreo(), $usuario->GetPassword(), $usuario->GetIdTipoUsuario());
					$usuarioCliente->SetIdCliente($usuarioCliente->getIdClienteById());

					$usuarioCliente->SetId(Control::encriptar(strval($usuarioCliente->GetId())));
					
					$cliente = new Cliente($usuarioCliente->GetIdCliente()); 

					$cliente = $cliente->getClienteActivoById();

					if (empty($cliente)) {
						$respuesta = -4; // El cliente no esta activo para el usuario
						return $respuesta;
					}


					$sessionCtrl->SetObjectToSession('usuario',$usuarioCliente);

					$sessionCtrl->SetObjectToSession('cliente',$cliente);
					
					break;
				default:
					
					break;
			}

			$sessionCtrl->SetObjectToSession('tipoUsuario',$tipoUsuario);

			$sessionCtrl->SetObjectToSession('modulos',$modulos);

			$sessionCtrl->SetObjectToSession('categoria',$categoria);

			return 1; // Correcto
		}
		
	}

 ?>