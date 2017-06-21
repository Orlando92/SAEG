<?php 

	include_once('../rest/SimpleRest.php');
	include_once('../controller/ServicioCampoCtrl.php');

	class ServicioCampoRestHandler extends SimpleRest{

		public function ListarServicioCampos($iIdServicio){

			$servicioCampoCtrl = new ServicioCampoCtrl(); 

			$dataJson = $servicioCampoCtrl->ListarServicioCampos($iIdServicio);

			$this->responder($dataJson);

		}
	}

 ?>