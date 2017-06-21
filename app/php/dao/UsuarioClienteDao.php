<?php  

	require_once('../db/ConexionSQL.php');

	class UsuarioClienteDao{

		public function getIdClienteById($iId){

			$sql = 	"
					
					SELECT 		iIdCliente
					FROM 		usuariocliente
					WHERE 		iId = '".$iId."'
					
					";

			$iIdCliente = ConexionSQL::get_valor_query($sql, 'iIdCliente');

			if (!empty($iIdCliente)) {
				return $iIdCliente;
			}
				
			return null;	

		}

	}

?>