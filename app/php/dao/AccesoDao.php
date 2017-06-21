<?php  

	require_once("../model/Acceso.php");
	require_once("../db/ConexionSQL.php");
	
	class AccesoDao{

		public function getAccesosByIdTipoUsuario($iId){

			$sql = 	"SELECT iId, iIdTipoUsuario, iIdModulo FROM acceso WHERE iIdTipoUsuario = '".$iId."'";
			$rows = ConexionSQL::get_cursor($sql);
			if (!empty($rows)) {

				$array = array();
				while ($row = $rows->fetch_assoc()){
					$acceso = new Acceso();
					$acceso -> SetId((int)$row['iId']);
					$acceso -> SetIdTipoUsuario((int)$row['iIdTipoUsuario']);
					$acceso -> SetIdModulo((int)$row['iIdModulo']);				
					array_push($array,$acceso);					
				}

				return $array;
			}
				
			return null;
		}

	}

?>