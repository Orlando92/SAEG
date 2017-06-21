<?php  

	include_once('../rest/SimpleRest.php');
	include_once('../controller/SessionCtrl.php');
	include_once('../model/Modulo.php');

	class SessionRestHandler extends SimpleRest{
		
		public function IsLogged(){

			$sessionCtrl = new SessionCtrl();

			$dataJson = $sessionCtrl->IsLogged();

			$this->responder($dataJson);

		}

		public function DestroySession(){

			$sessionCtrl = new SessionCtrl();

			$sessionCtrl->destroySession();

			echo json_encode(1);

		}

		public function GetObjectSession($objectName){

			$sessionCtrl = new SessionCtrl();

			$data = $sessionCtrl->GetObjectSession($objectName);

			$dataJson = json_encode($data);

			$this->responder($data); 

		}

		public function EsModuloAutorizado($sDescripcion){

			$sessionCtrl = new SessionCtrl();
			$dataJson = $sessionCtrl->GetObjectSession('modulos');
			if (empty($dataJson)) {
				$this->responder(0);	
				return;
			}
			$data = json_decode($dataJson);

			$encuentra = 0;
			
			foreach ($data as $value) {
				
				if (strtoupper($value->sDescripcion) == strtoupper($sDescripcion)) {
					$encuentra = 1;
					break;
				}
			}
			$this->responder($encuentra);			
		}

	}

?>