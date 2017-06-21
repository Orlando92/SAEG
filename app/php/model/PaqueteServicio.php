<?php 

class PaqueteServicio implements JsonSerializable{

	private $iId;
	private $iIdPaquete;
	private $iIdServicio;

	public function GetId(){ return $this->iId; }
	public function SetId($value){ $this->iId = $value; }

	public function GetIdPaquete(){ return $this->iIdPaquete; }
	public function SetIdPaquete($value){ $this->iIdPaquete = $value; }

	public function GetIdServicio(){ return $this->iIdServicio; }
	public function SetIdServicio($value){ $this->iIdServicio = $value; }

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