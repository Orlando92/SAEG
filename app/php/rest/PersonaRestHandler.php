<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/PersonaCtrl.php');

	class PersonaRestHandler extends SimpleRest{

		public function ListarPersonaByDni($sDni){

			$personaCtrl = new PersonaCtrl();

			$dataJson = $personaCtrl->ListarPersonaByDni($sDni);

			if (empty($dataJson)) {
				$statusCode = 404;
			}else{
				$statusCode = 200;
			}
			$this ->setHttpHeaders($statusCode);
			print_r($dataJson);

			
		
		}
	}

 ?>