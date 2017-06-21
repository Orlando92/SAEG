<?php  
	
	require_once("../db/ConexionSQL.php");

	class ServicioCampoDao{

		public function ListarServicioCamposQuery($iIdServicio){
			$query = "SELECT * FROM serviciocampo where iIdServicio = ".$iIdServicio.";";

			return $query;
		}

		//--------------------------------------------------------------------------------//

		public function ListarServicioCampos($iIdServicio){

			$sql = $this->ListarServicioCamposQuery($iIdServicio);
			return ConexionSQL::get_json_rows($sql);

		}

	}

?>