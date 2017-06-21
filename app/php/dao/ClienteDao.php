<?php  

	include_once('../db/ConexionSQL.php');
	include_once('../model/Cliente.php');

	/**
	* 
	*/
	class ClienteDao{

		//----------------------------------------------------------------------------------

		public function CrearClienteQuery($cliente){

			return "INSERT INTO cliente(sDescripcion, sRuc, iIdContacto, sRazonSocial) values('".$cliente->GetDescripcion()."', '".$cliente->GetRuc()."', @iIdContacto, '".$cliente->GetRazonSocial()."')";

		}

		public function ListarCantidadSolicitudesClientesQuery(){
			return "SELECT C.iId, C.sDescripcion, Count(S.iId) iCantidadSolicitudesPendientes FROM cliente C inner join usuariocliente US on C.iId = US.iIdCliente INNER JOIN solicitud S ON US.iId = S.iIdUsuarioCliente and S.iId in (SELECT s2.iId from solicitud s2 inner join	solicituddetalle sd on s2.iId = sd.iIdSolicitud where s2.iId = S.iId ) WHERE IFNULL(S.sInforme,'') = '' AND IFNULL(S.sAnexo,'') = '' GROUP BY C.iId, C.sDescripcion;";
		}

		public function ListarClientesActivosQuery(){

			return "SELECT * FROM cliente WHERE IACTIVO = 1";

		}

		//----------------------------------------------------------------------------------
		
		public function getClienteActivoById($iId){
			// SE LE QUITO LA COMA DESPUES DE iActivo
			$sql = 	"					
					SELECT 		iId, 
								sDescripcion, 
								iActivo 
								
					FROM 		cliente 
					WHERE 		iId = ".$iId."
					AND 		iActivo = 1					
					";

			$row = ConexionSQL::get_row($sql);

			if (!empty($row)) {
				$cliente = new Cliente();
				$cliente -> SetId((int)$row['iId']);
				$cliente -> SetDescripcion($row['sDescripcion']);
				$cliente -> SetActivo(1);
				return $cliente;
			}
				
			return null;

		}

		public function ListarCantidadSolicitudesClientes(){

			$sql = $this->ListarCantidadSolicitudesClientesQuery();

			return ConexionSQL::get_json_rows($sql);
		}

		public function ListarClientesActivos(){

			$sql = $this->ListarClientesActivosquery();

			return ConexionSQL::get_json_rows($sql);

		}

		//public function CrearClienteQuery

	}

?>