<?php  

	require_once("../model/ServicioCampo.php");
	
	class ServicioCampoCtrl{

		public function ListarServicioCampos($iIdServicio){

			$servicioCampo = new ServicioCampo();

			$servicioCampo->SetIdServicio($iIdServicio);

			return $servicioCampo->ListarServicioCampos();
		}

		
	}

?>