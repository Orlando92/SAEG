<?php 

class InformacionSolicitudDetalle implements JsonSerializable{

	private $iId;
	private $iIdSolicitudDetalle;
	private $iIdInformacion;
	private $dFechaRegistro;

	public function GetId(){ return $this->iId; }
	public function SetId($value){ $this->iId = $value; }

	public function GetIdSolicitudDetalle(){ return $this->iIdSolicitudDetalle; }
	public function SetIdSolicitudDetalle($value){ $this->iIdSolicitudDetalle = $value; }

	public function GetIdInformacion(){ return $this->iIdInformacion; }
	public function SetIdInformacion($value){ $this->iIdInformacion = $value; }

	public function GetFechaRegistro(){ return $this->dFechaRegistro; }
	public function SetFechaRegistro($value){ $this->dFechaRegistro = $value; }

		//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }


}

 ?>