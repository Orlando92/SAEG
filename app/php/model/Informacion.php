<?php 
	
	require_once("../dao/InformacionDao.php");


	class Informacion implements JsonSerializable{

		private $iId;
		private $iIdPersona;
		private $iIdServicioCampo;
		private $iIdUsuarioOperacion;
		private $dFechaRegistro;
		private $sContenido;
		private $iActivo;

		public function GetId(){ return $this->iId; }
		public function SetId($value){ $this->iId = $value; }

		public function GetIdPersona(){ return $this->iIdPersona; }
		public function SetIdPersona($value){ $this->iIdPersona = $value; }

		public function GetIdServicioCampo(){ return $this->iIdServicioCampo; }
		public function SetIdServicioCampo($value){ $this->iIdServicioCampo = $value; }

		public function GetIdUsuarioOperacion(){ return $this->iIdUsuarioOperacion; }
		public function SetIdUsuarioOperacion($value){ $this->iIdUsuarioOperacion = $value; }

		public function GetFechaRegistro(){ return $this->dFechaRegistro; }
		public function SetFechaRegistro($value){ $this->dFechaRegistro = $value; }

		public function GetContenido(){ return $this->sContenido; }
		public function SetContenido($value){ $this->sContenido = $value; }

		public function GetActivo(){ return $this->iActivo; }
		public function SetActivo($value){ $this->iActivo = $value; }

			//-------------------------------------------------------------------------

		public function jsonSerialize() {
			$varsClase = get_class_vars(get_class($this));

		 	foreach ($varsClase as $key => $value) {
		 		$vars[$key] = $this->$key;
		 	}

		 	return $vars;
		}

		//---------------------------------------------------------------------------------//

		public function ListarInformacionServicioPersona($iIdPersona, $iIdServicio){

			$informacionDao = new InformacionDao();
			return $informacionDao->ListarInformacionServicioPersona($iIdPersona, $iIdServicio);

		}

		public function IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio,$iIdUsuario, $detalle){



			$informacionDao = new InformacionDao();

			return $informacionDao->IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio, $iIdUsuario, $detalle);
		}

	}

?>