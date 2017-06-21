<?php 

	require_once("../dao/SolicitudDetalleDao.php");

	class SolicitudDetalle implements JsonSerializable
	{
		private $iId;
		private $iIdSolicitud;
		private $iIdServicio;
		private $iIdUsuarioOperacion;
		private $iExiste;
		private $iIdPaquete;

		//------------------------------------------------------------------------

		public function GetId(){ return $this->iId; }

		public function SetId($value){ $this->iId = $value;	}

		public function GetIdSolicitud(){ return $this->iId; }

		public function SetIdSolicitud($value){ $this->iIdSolicitud = $value;}

		//-------------------------------------------------------------------------

		 public function jsonSerialize() {
			$varsClase = get_class_vars(get_class($this));

		 	foreach ($varsClase as $key => $value) {
		 		$vars[$key] = $this->$key;
		 	}

		 	return $vars;
		 }

		//----------------------------------------------------------------------

		 public function ListarServiciosByIdSolicitud(){
		 	$solicitudDetalleDao = new SolicitudDetalleDao();
		 	return $solicitudDetalleDao->ListarServiciosByIdSolicitud($this->iIdSolicitud);
		 }

		
	}
 ?>