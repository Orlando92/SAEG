<?php 

	require_once('../dao/PaqueteDao.php');

	class Paquete implements JsonSerializable{

		private $iId;
		private $sDescripcion;
		private $iActivo;
		private $iIdTipoPaquete;


		public function GetId(){ return $this->iId; }
		public function SetId($value){ $this->iId = $value; }

		public function GetDescripcion(){ return $this->sDescripcion; }
		public function SetDescripcion($value){ $this->sDescripcion = $value; }

		public function GetActivo(){ return $this->iActivo; }
		public function SetActivo($value){ $this->iActivo = $value; }

		public function GetIdTipoPaquete(){ return $this->iIdTipoPaquete; }
		public function SetIdTipoPaquete($value){ $this->iIdTipoPaquete = $value;}

		//-------------------------------------------------------------------------



		//-------------------------------------------------------------------------

		public function jsonSerialize() {

			$varsClase = get_class_vars(get_class($this));

			foreach ($varsClase as $key => $value) {
				$vars[$key] = $this->$key;
			}

			return $vars;
		}

		//---------------------------------------------------------------------------

		public function ListarPaquetesActivos(){

			$paqueteDao = new PaqueteDao();

			return $paqueteDao->ListarPaquetesActivos();

		}

		public function ListarPaquetesByIdSolicitud($iIdSolicitud){

			$paqueteDao = new PaqueteDao();

			return $paqueteDao->ListarPaquetesByIdSolicitud($iIdSolicitud);

		}

		public function ListarPaquetesParaEditarSolicitud($iIdSolicitud){
			$paqueteDao = new PaqueteDao();
			return $paqueteDao->ListarPaquetesParaEditarSolicitud($iIdSolicitud);
		}

	 }
 
?>