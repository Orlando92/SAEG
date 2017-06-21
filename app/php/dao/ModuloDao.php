<?php  

	require_once('../model/Modulo.php');
	
	class ModuloDao{

		public function GetModuloActivoById($iId){

			$sql = 	"					
					SELECT 		iId, 
								sDescripcion, 
								sRuta, 
								sNombre, 
								sIcono
					FROM 		modulo 
					WHERE 		iId = '".$iId."'	
					AND 		iActivo = 1				
					";

			$row = ConexionSQL::get_row($sql);
			if (!empty($row)) {
				$modulo = new Modulo();
				$modulo -> SetId((int)$row['iId']);
				$modulo -> SetDescripcion($row['sDescripcion']);
				$modulo -> SetRuta($row['sRuta']);			
				$modulo ->SetActivo(1);
				$modulo -> SetNombre($row['sNombre']);
				$modulo -> SetIcono($row['sIcono']);
				return $modulo;
			}
							
			return null;
		}

	}

?>