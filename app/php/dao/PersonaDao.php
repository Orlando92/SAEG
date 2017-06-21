<?php 

	require_once("../db/ConexionSQL.php");
	require_once("../model/Persona.php");

	class PersonaDao{

		//-------------------------------------------

		public static function CrearPersonaQuery($persona)
		{ 
			return "INSERT INTO persona(sApellidoPaterno, sApellidoMaterno, sDni, sNombres) VALUES(UPPER('".$persona->GetApellidoPaterno()."'),UPPER('".$persona->GetApellidoMaterno()."'),UPPER('".$persona->GetDni()."'),UPPER('".$persona->GetNombres()."'));";
		}
		
		public static function ExisteDniPersonaQuery($persona)
		{ 
			return "
					SELECT 	COUNT(*) as existe
					FROM 	persona
					WHERE 	sDni = '".$persona->GetDni()."'
					";
		}

		public static function EditarPersonaQuery($persona)
		{
			$query = "UPDATE persona";
			$query .= " SET sDni = ".$persona->GetDni().",";
			$query .= " sApellidoPaterno = UPPER('".$persona->GetApellidoPaterno()."'),";
			$query .= " sApellidoMaterno = UPPER('".$persona->GetApellidoMaterno()."'),";
			$query .= " sNombres = UPPER('".$persona->GetNombres()."')";
			$query .= " where iId = ".$persona->GetId().";";

			return $query;
		}

		public static function ListarPersonaByDniQuery($sDni)
		{
			return "SELECT distinct p.* FROM persona p inner join solicitud s on s.iIdPersona = p.iId where sDni = ".$sDni;
		}

		public static function ExisteSolicitudPersonaQuery($iIdPersona){

			return "SELECT COUNT(*) as existe FROM persona p INNER JOIN solicitud s on s.iIdPersona = p.iId WHERE p.iId = ".$iIdPersona.";";
		} 

		public static function GetIdPersonaByDniQuery($persona)
		{
			return "SELECT iId as IdPersona FROM persona WHERE sDni LIKE '".$persona->GetDni()."';";
		}

		public static function ListarPersonaByIdSolicitudQuery($iIdSolicitud){

			return "SELECT p.* FROM solicitud s inner join persona p on s.iIdPersona = p.iId where s.iId = ".$iIdSolicitud;
		}

		public static function EliminarPersonaQuery($iIdPersona){
			return "DELETE persona WHERE iId = ".$iIdPersona.";";
		}

		//-------------------------------------------

		public function CrearPersona($persona){

			if ($this->ExisteDniPersona($persona)) {

				$IdPersona = $this->GetIdPersonaByDni($Persona);		
				$persona->SetId($IdPersona);
				return false;
			}

			$sql = $this::CrearPersonaQuery($persona);

			$resultado = ConexionSQL::ejecutar_idu($sql);
			
			if ($resultado == 1) {

				$IdPersona = $this->GetIdPersonaByDni($persona);				
				$persona->SetId($IdPersona);				
			}

			return true;

		}

		public function ExisteDniPersona($persona){

			$sql = $this::ExisteDniPersonaQuery($persona);

			$existe = ConexionSQL::get_valor_query($sql, 'existe');

			if ($existe > 0) {
				return true;
			}

			return false;

		}

		public function ExisteSolicitudPersona($iIdPersona){

			$sql = $this::ExisteSolicitudPersonaQuery($iIdPersona);

			$existe = ConexionSQL::get_valor_query($sql, 'existe');

			if ($existe > 0) {
				return true;
			}

			return false;
		}


		public function ListarPersonaByDni($sDni){

			$sql = $this::ListarPersonaByDniQuery($sDni);

			return ConexionSQL::get_json_row($sql);
		}

		public function GetIdPersonaByDni($persona){
			
			$sql = $this::GetIdPersonaByDniQuery($persona);
			
			return ConexionSQL::get_valor_query($sql, 'IdPersona');			
		}

		public function ListarPersonaByIdSolicitud($iIdSolicitud){
			
			$sql = $this::ListarPersonaByIdSolicitudQuery($iIdSolicitud);

			return ConexionSQL::get_json_rows($sql);
		}

		public function EliminarPersona($iIdPersona){

			$sql = $this::EliminarPersonaQuery($iIdPersona);

			$resultado = ConexionSQL::ejecutar_idu($sql);
			
			if ($resultado == 1) {

				$IdPersona = $this->GetIdPersonaByDni($persona);				
				$persona->SetId($IdPersona);				
			}

			return true;
		}



	}

 ?>