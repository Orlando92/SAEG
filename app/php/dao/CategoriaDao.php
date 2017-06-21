<?php  

	require_once('../model/Categoria.php');
	require_once('../db/ConexionSQL.php');
	class CategoriaDao {

		function GetCategoriaById($iId){

			$sql = 	"
					
					SELECT 		iId, 
								sDescripcion
					FROM 		categoria 
					WHERE 		iId = '".$iId."'
					
					";

			$row = ConexionSQL::get_row($sql);

			if (!empty($row)) {
				$categoria = new Categoria();
				$categoria -> SetId((int)$row['iId']);
				$categoria -> SetDescripcion($row['sDescripcion']);
				return $categoria;
			}
				
			return null;
		}

	}

?>