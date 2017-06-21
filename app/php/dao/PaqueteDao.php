<?php  

	require_once("../model/Paquete.php");
	require_once("../db/ConexionSQL.php");

class PaqueteDao{

	//---------------------------------------------------

	public function ListarPaquetesActivosQuery(){

		return "SELECT iId, sDescripcion, iActivo, iIdTipoPaquete FROM paquete WHERE iActivo= 1;";

	}

	public function ListarPaquetesByIdSolicitudQuery($iIdSolicitud){

		$query  = "SELECT 		distinctrow p.*";
		$query .= " FROM 		paquete p";
		$query .= " INNER JOIN 	solicituddetalle sd";
		$query .= " ON			p.iId = sd.iIdPaquete";
		$query .= " AND 			sd.iIdSolicitud = ".$iIdSolicitud.";";

		return $query;
	}

	public function ListarPaquetesParaEditarSolicitudQuery($iIdSolicitud){

		$query = "SELECT		distinctrow p.iId, p.iIdTipoPaquete, p.sDescripcion, ";
		$query .= "				CASE "	;
		$query .= "				WHEN 	ISNULL(sd.iId) = true or p.iIdTipoPaquete != 1";
		$query .= "				THEN 	0";
		$query .= "				ELSE	1 ";
		$query .= "            	END as 'iSeleccionado'";
		$query .= " FROM 	  	paquete p" ;
		$query .= " LEFT JOIN 	solicituddetalle sd";
		$query .= " on				p.iId = sd.iIdPaquete";
		$query .= "				and sd.iIdSolicitud = ".$iIdSolicitud;
		$query .= " WHERE 		(	p.iActivo = 1 ";
		$query .= "				or	ISNULL(sd.iId) = false";
		$query .= "            	)";

		return $query;

	}

	
	//---------------------------------------------------

	public function ListarPaquetesActivos(){

		$sql = $this->ListarPaquetesActivosQuery();

		$rows = ConexionSQL::get_cursor($sql);

		if (!empty($rows)) {

			$array = array();

			while ($row = $rows->fetch_assoc()){
				$paquete = new Paquete();
				$paquete -> SetId((int)$row['iId']);
				$paquete -> SetDescripcion($row['sDescripcion']);
				$paquete -> SetActivo((int)$row['iActivo']);
				$paquete -> SetIdTipoPaquete((int)$row['iIdTipoPaquete']);		
				array_push($array,$paquete);					
			}

			return $array;
		}
			
		return null;

	}

	public function ListarPaquetesByIdSolicitud($iIdSolicitud){
		
		$sql = $this->ListarPaquetesByIdSolicitudQuery($iIdSolicitud);

		$rows = ConexionSQL::get_cursor($sql);

		if (!empty($rows)) {

			$array = array();

			while ($row = $rows->fetch_assoc()){
				$paquete = new Paquete();
				$paquete -> SetId((int)$row['iId']);
				$paquete -> SetDescripcion($row['sDescripcion']);
				$paquete -> SetActivo((int)$row['iActivo']);
				$paquete -> SetIdTipoPaquete((int)$row['iIdTipoPaquete']);		
				array_push($array,$paquete);					
			}

			return $array;
		}
			
		return null;

	}

	public function ListarPaquetesParaEditarSolicitud($iIdSolicitud){

		$sql = $this->ListarPaquetesParaEditarSolicitudQuery($iIdSolicitud);

		return ConexionSQL::get_json_rows($sql);

	}



	//--------------------------------------------------------------

}


?>