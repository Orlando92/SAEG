<?php 
	require_once("../model/Persona.php");

	class PersonaCtrl{

		public function ListarPersonaByDni($sDni){
			$persona = new Persona();
			$persona->SetDni($sDni);
			return $persona->ListarPersonaByDni();
		}
		
	}
 ?>