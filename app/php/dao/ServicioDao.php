<?php  


	require_once("../db/ConexionSQL.php");
	require_once("../model/Servicio.php");
	
	class ServicioDao{

		public function ListarServiciosByIdSolicitudQuery($iIdSolicitud){

			$query = " SELECT 		distinctrow se.*, sd.iIdPaquete" ;
			$query .= " FROM			servicio se" ;
			$query .= " INNER JOIN 	solicituddetalle sd" ;
			$query .= " on			se.iId = sd.iIdServicio" ;
			$query .= " WHERE		sd.iIdSolicitud = ".$iIdSolicitud.";";

			return $query;

		}

		public function ListarServiciosDePaquetesParaEditarSolicitudQuery($iIdSolicitud){
			$query ="SELECT 		s.*,";
			$query .="			CASE	 	ISNULL(ps.iIdPaquete)";
			$query .="				WHEN 	true";
			$query .="				THEN 	sd.iIdPaquete";
			$query .="				ELSE	ps.iIdPaquete";
			$query .="			END AS iIdPaquete, ";
			$query .="            CASE		(NOT ISNULL(sd.iIdPaquete) and (sd.iIdPaquete = ps.iIdPaquete or ISNULL(ps.iIdPaquete)))";
			$query .=" 				WHEN	TRUE";
			$query .="                THEN	1";
			$query .="                ELSE    0";
			$query .="			END AS		'iSeleccionado'";
			$query .=" FROM 		servicio s";
			$query .=" LEFT JOIN 	paqueteservicio ps";
			$query .=" ON			s.iId = ps.iIdServicio";
			$query .=" LEFT JOIN 	solicituddetalle sd" ;
			$query .=" ON			s.iId = sd.iIdServicio";
			$query .="			and sd.iIdSolicitud = ".$iIdSolicitud;
			$query .=" WHERE		(	NOT ISNULL(ps.iIdPaquete)";
			$query .="			OR 	NOT ISNULL(sd.iIdPaquete)";
			$query .="            );";

			return $query;

		}

		public function ListarServiciosPaquetesActivosQuery(){

			$query =" select s.*, ps.iIdPaquete from servicio s";
			$query .=" inner join paqueteservicio ps";
			$query .=" on s.iId = ps.iIdServicio";
			$query .=" where s.iActivo = 1;";

			return $query;

		}


		//----------------------------------------------------------------------------------

		public function ListarServiciosPaquetesActivos(){

			$sql = $this->ListarServiciosPaquetesActivosQuery();

			return ConexionSQL::get_json_rows($sql);			
		}

		
		public function ListarServiciosByIdSolicitud($iIdSolicitud){

			$sql = $this->ListarServiciosByIdSolicitudQuery($iIdSolicitud);

			return ConexionSQL::get_json_rows($sql);
		}

		public function ListarServiciosDePaquetesParaEditarSolicitud($iIdSolicitud){

			$sql = $this->ListarServiciosDePaquetesParaEditarSolicitudQuery($iIdSolicitud);

			return ConexionSQL::get_json_rows($sql);
		}

		




	}

?>