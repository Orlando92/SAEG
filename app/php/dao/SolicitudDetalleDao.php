<?php
	
	require_once("../db/ConexionSQL.php");

	class SolicitudDetalleDao {

		public function ListarServiciosByIdSolicitudQuery($iIdSolicitud){
			$query = "SELECT s.iId, sd.iExiste, sd.iId as iIdSolicitudDetalle, s.sDescripcion as sDescripcionServicio FROM solicituddetalle sd inner join servicio s on sd.iIdServicio = s.iId where sd.iIdSolicitud = ".$iIdSolicitud.";";
			return $query;
		}

		/*************************************************************************************/

		public function ListarServiciosByIdSolicitud($iIdSolicitud){
			$query = $this->ListarServiciosByIdSolicitudQuery($iIdSolicitud);
			return ConexionSQL::get_json_rows($query);
		}


	}


?>