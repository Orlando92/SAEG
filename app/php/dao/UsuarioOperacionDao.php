<?php 

	require_once('../db/ConexionSQL.php'); 
	require_once('../dao/UsuarioDao.php');
	require_once('../dao/PersonaDao.php');
	require_once('../dao/SedeDao.php');
	
	class UsuarioOperacionDao{

		//------------------------------------------------------

		public static function CrearUsuarioOperacionQuery($usuarioOperacion){

			return "INSERT INTO usuariooperacion(iId, iIdSede) values (@iId, ".$usuarioOperacion->GetIdSede().");";
		}

		//------------------------------------------------------

		public function GetIdSedeById($iId){

			$sql = 	"
					
					SELECT 		iIdSede
					FROM 		usuariooperacion
					WHERE 		iId = '".$iId."'
					
					";

			$iIdSede = ConexionSQL::get_valor_query($sql, 'iIdSede');

			if (!empty($iIdSede)) {
				return $iIdSede;
			}
				
			return null;	

		}
		
		public function CrearUsuarioOperacion($usuarioOperacion){
			
			$personaDao = new PersonaDao();

			if ($personaDao->ExisteDniPersona($usuarioOperacion)) {
				
				return -2; //Ya existe DNI
			}

			$usuarioDao = new UsuarioDao();

			if ($usuarioDao->ExisteCorreo($usuarioOperacion->GetCorreo())) {
				
				return -3; //Ya existe Correo
			}

			$sedeDao = new SedeDao();

			$sede = $sedeDao->GetSedeActivoById($usuarioOperacion->GetIdSede());

			if (empty($sede)) {
				return -4; //No existe Sede
			}

			$sql  = PersonaDao::CrearPersonaQuery($usuarioOperacion);

			$sql .= "SET @iId = LAST_INSERT_ID();";

			$sql .= UsuarioDao::CrearUsuarioQuery($usuarioOperacion);

			$sql .= UsuarioOperacionDao::CrearUsuarioOperacionQuery($usuarioOperacion);

			return ConexionSQL::transaction_query($sql);
		}

	}



?>