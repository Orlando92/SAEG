<?php  
	
	require_once('../model/Sede.php');
	require_once('../db/ConexionSQL.php');
	
	class SedeDao{

		public function GetSedeActivoById($iId){
			$sql = 	"					
					SELECT 		iId, 
								sDescripcion, 
								sDireccion
					FROM 		sede 
					WHERE 		iId = ".$iId." AND iActivo = 1					
					";


			$row = ConexionSQL::get_row($sql);

			if (!empty($row)) {

				$sede = new Sede();
				$sede -> SetId((int)$row['iId']);
				$sede -> SetDescripcion($row['sDescripcion']);
				$sede -> SetDireccion($row['sDireccion']);
				$sede -> SetActivo(1);
				return $sede;
			}
				
			return null;
		}

	}


?>