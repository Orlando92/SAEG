<?php 
	
	include_once('../dao/ClienteDao.php');

	class Cliente implements JsonSerializable{

		private $iId;
		private $sDescripcion;
		private $sRuc;
		private $iIdContacto;
		private $sRazonSocial;
		private $iActivo;

		//------------------------------------------------------

		function __construct()
		{
			$params = func_get_args();
			$num_params = func_num_args();
			$funcion_constructor ='__construct'.$num_params;
			if (method_exists($this,$funcion_constructor)) {
				call_user_func_array(array($this,$funcion_constructor),$params);
			}
		}

		//--------------------------------------------------------------------------

		function __construct1($iId)
		{
			$this->iId = $iId;
		}

		//------------------------------------------------------------------------

		public function SetId($value){$this->iId = $value;}

		public function GetId(){return $this->iId;}

		public function SetDescripcion($value){$this->sDescripcion = $value;}

		public function GetDescripcion(){return $this->sDescripcion;}

		public function SetRuc($value){$this->sRuc = $value;}

		public function GetRuc(){return $this->sRuc;}

		public function SetIdContacto($value){$this->iIdContacto = $value;}

		public function GetIdContacto(){return $this->iIdContacto;}

		public function SetRazonSocial($value){$this->sRazonSocial = $value;}

		public function GetRazonSocial(){return $this->sRazonSocial;}

		public function SetActivo($value){$this->iActivo = $value;}

		public function GetActivo(){return $this->iActivo;}

		//-------------------------------------------------------------------------

	 public function jsonSerialize() {
		$varsClase = get_class_vars(get_class($this));

	 	foreach ($varsClase as $key => $value) {
	 		$vars[$key] = $this->$key;
	 	}

	 	return $vars;
	 }

	 public function deserealizarCliente($clienteJson){
	 	$array_cliente = json_decode($clienteJson);		
		foreach ($array_cliente as $field => $value) {						
			$SetProperty = 'Set'.substr($field, 1);
			$array_value[0] = $value;
			if (method_exists($this, $SetProperty)) {
				call_user_func_array(array($this,$SetProperty), $array_value);
			}
		}
	 }


		//----------------------------------------------------------

		public function getClienteActivoById(){

			$clienteDao = new ClienteDao();

			return $clienteDao->getClienteActivoById($this->iId);

		}

		public function ListarCantidadSolicitudesClientes(){

			$clienteDao = new ClienteDao();

			return $clienteDao->ListarCantidadSolicitudesClientes();
		}

		public function ListarClientesActivos(){

			$clienteDao = new ClienteDao();

			return $clienteDao->ListarClientesActivos();
		}

		


	}

 ?>