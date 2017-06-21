<?php  
	
	require_once("../db/ConexionSQL.php");

	class InformacionDao{

		public function ListarInformacionServicioPersonaQuery($iIdPersona, $iIdServicio){
			$query = "SELECT i.iId as iIdInformacion, i.dFechaInformacion, sc.iId as iIdServicioCampo, sc.sDescripcion, isc.sContenido FROM informacion i inner join informacionserviciocampo isc on i.iId = isc.iIdInformacion inner join serviciocampo sc on isc.iIdServicioCampo = sc.iId  where sc.iIdServicio = ".$iIdServicio." and i.iIdPersona = ".$iIdPersona." and i.iActivo = 1 and sc.iActivo = 1 ;";
			
			return $query;
		}

		public function IngresarInformacionServicioPersonaQuery($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio,$iIdUsuario, $detalle){

			$query = "UPDATE solicituddetalle SET iExiste = ".$iExiste.", iIdUsuarioOperacion = ".$iIdUsuario." WHERE iId = ".$iIdSolicitudDetalle."; ";

			for ($i=0; $i < count($detalle); $i++) { 

				$query .= " INSERT INTO informacion(iIdPersona, iIdServicio, iIdUsuarioOperacion, dFechaInformacion, dFechaRegistro, iActivo) "; 
				$query .= "VALUES(".$iIdPersona.",".$iIdServicio.", ".$iIdUsuario.", CAST('".substr($detalle[$i]->dFecha,0,10)."' as DATE), CAST(NOW() AS DATE), 1) ;";

				$query .= "set @iIdInformacion = LAST_INSERT_ID();";

				$camposServicio = $detalle[$i]->camposServicio;

				for ($j=0; $j < count($camposServicio); $j++) { 
						
						$query.=" INSERT INTO informacionserviciocampo(iIdServicioCampo, sContenido, iActivo, iIdInformacion) ";
						$query.=" VALUES(".$camposServicio[$j]->iId.", '".$camposServicio[$j]->sValor."',1,@iIdInformacion);";
				}
			}


			return $query;
		}

		//---------------------------------------------------------------------------------------------//

		public function ListarInformacionServicioPersona($iIdPersona, $iIdServicio){
			
			$sql = $this->ListarInformacionServicioPersonaQuery($iIdPersona, $iIdServicio);
			return ConexionSQL::get_json_rows($sql);
		}

		public function IngresarInformacionServicioPersona($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio,$iIdUsuario, $detalle){
			 	
			$sql = $this->IngresarInformacionServicioPersonaQuery($iIdSolicitudDetalle, $iExiste, $iIdPersona, $iIdServicio,$iIdUsuario, $detalle);
			//return json_encode($sql);

			if (count($detalle) > 0) {
				return ConexionSQL::transaction_query($sql);
			}

			return ConexionSQL:: ejecutar_idu($sql);
		}



	}

?>