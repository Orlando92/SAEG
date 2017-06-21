<?php

	require_once("../db/ConexionSQL.php");
	require_once("../dao/PersonaDao.php");
	require_once("../model/Persona.php");
	require_once("../model/Servicio.php");
	require_once("../model/UsuarioCliente.php");

	class SolicitudDao{

		public function InsertarSolicitudQuery($iIdUsuario, $iIdPersona){

			$query = " insert into solicitud(iIdPersona, iIdUsuarioCliente, dFechaPedido) values(".$iIdPersona.",".$iIdUsuario.", now());";

			return $query;

		}

		public function InsertarServiciosInclusivosEnSolicitudParaCrearQuery($iIdPaqueteInclusivo){

			if ($iIdPaqueteInclusivo == 0) {
				return '';
			}

			$query =   " insert into solicituddetalle(iIdSolicitud, iIdServicio, iIdPaquete)";
			$query .=   " select @iIdSolicitud, iIdServicio, iIdPaquete";
			$query .=	" from 	paqueteservicio ";
			$query .=	" where 	iIdPaquete = ".$iIdPaqueteInclusivo.";";

			return $query;

		}

		public function InsertarServiciosNoInclusivosEnSolicitudParaCrearQuery($servicios){

			if (empty($servicios)) {

				return '';

			}

			$arregloServicios = '';

			foreach ($servicios as $value) {
				$arregloServicios .= "(@iIdSolicitud,".$value->iId.",".$value->iIdPaquete."),";
			}

			$arregloServicios = substr($arregloServicios, 0, -1);

			$query = " insert into solicituddetalle(iIdSolicitud, iIdServicio, iIdPaquete)";
			$query .= " values ".$arregloServicios.";";

			return $query;

		}


		public function InsertarServiciosInclusivosEnSolicitudParaEditarQuery($iIdSolicitud,$iIdPaqueteInclusivo){

			if ($iIdPaqueteInclusivo == 0) {
				return '';
			}

			$query =   " insert into solicituddetalle(iIdSolicitud, iIdServicio, iIdPaquete)";
			$query .=   " select ".$iIdSolicitud.", iIdServicio, iIdPaquete";
			$query .=	" from 	paqueteservicio ";
			$query .=	" where 	iIdPaquete = ".$iIdPaqueteInclusivo.";";

			return $query;

		}

		public function InsertarServiciosNoInclusivosEnSolicitudParaEditarQuery($iIdSolicitud, $servicios){

			if (empty($servicios)) {

				return '';

			}

			$arregloServicios = '';

			foreach ($servicios as $value) {
				$arregloServicios .= "(".$iIdSolicitud.",".$value->iId.",".$value->iIdPaquete."),";
			}

			$arregloServicios = substr($arregloServicios, 0, -1);

			$query = " insert into solicituddetalle(iIdSolicitud, iIdServicio, iIdPaquete)";
			$query .= " values ".$arregloServicios.";";

			return $query;

		}

		public function ListarDatosSolicitudQuery($iIdSolicitud){
			$query = "select dFechaPedido, c.sDescripcion, concat(sApellidoPaterno , ' ' , sApellidoMaterno , ' ' , sNombres) as 'sPersona', p.iId as iIdPersona from solicitud s inner join usuariocliente uc on uc.iId = s.iIdUsuarioCliente 
				inner join cliente c on c.iId = uc.iIdCliente inner join usuario u on u.iId = uc.iId inner join persona p on s.iIdPersona = p.iId where s.iId = ".$iIdSolicitud.";";

			$query = preg_replace("[\n|\r|\n\r]", ' ' , $query);

			return $query;
		}

		public function EditarIdPersonaSolicitudQuery($iIdPersona, $iIdSolicitud){

			$query = "UPDATE solicitud SET iIdPersona = ".$iIdPersona." WHERE iId = ".$iIdSolicitud.";";

			return $query;

		}

		public function EditarSolicitudQuery($iIdSolicitud, $persona,  $iIdPaqueteInclusivo, $servicios){

			$query = " delete from solicituddetalle where iIdSolicitud = ".$iIdSolicitud.";";

			$personaDao = new PersonaDao();

			if ($personaDao->ExisteDniPersona($persona)) {
				
				$iIdPersona = $personaDao->GetIdPersonaByDni($persona);

				$query .= $this->EditarIdPersonaSolicitudQuery($iIdPersona, $iIdSolicitud);

				if (!$personaDao->ExisteSolicitudPersona($persona->GetId())) {
					
					$personaDao->EliminarPersona($iIdPersona);
				}

			}else if($personaDao->ExisteSolicitudPersona($persona->GetId())){

				$personaDao->CrearPersona($persona); 

				$iIdPersona = $persona->GetId();

				$query .= $this->EditarIdPersonaSolicitudQuery($iIdPersona, $iIdSolicitud);

			}else{

				$query .= $personaDao::EditarPersonaQuery($persona);

			}			

			$query .= $this->InsertarServiciosInclusivosEnSolicitudParaEditarQuery($iIdSolicitud,$iIdPaqueteInclusivo);

			$query .= $this->InsertarServiciosNoInclusivosEnSolicitudParaEditarQuery($iIdSolicitud, $servicios);

			return $query;



		}

		public function EliminarSolicitudQuery($iIdSolicitud){

			$query = "delete from solicituddetalle where iIdSolicitud = ".$iIdSolicitud.";";
			$query .= "delete from solicitud where iId = ".$iIdSolicitud.";";

			return $query;
		}

		

		public function ListarSolicitudesPendientesQuery($iIdCliente){

			$query = "	SET @sql = NULL;
						SELECT
						  GROUP_CONCAT(DISTINCT
						    CONCAT(
						      'CASE WHEN ISNULL(MAX(IF(se.sDescripcion = ''',
						      se.sDescripcion,
						      ''',psSelectivo.iId, NULL))) THEN '''' ELSE 1 END AS ''',
							  se.sDescripcion,''''
						    )
						  ) INTO @sql
						FROM servicio se
						inner join paqueteservicio ps
						on 	se.iId = ps.iIdServicio
						inner join paquete p
						on p.iId= ps.iIdPaquete
						where p.iIdTipoPaquete = 3;

						set @query = concat('select 		so.iId as iIdSolicitud,
									CASE
											WHEN COUNT(p.iId) > 0
											THEN MAX(p.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteInclusivo'','
						            ,@sql,',
						            CASE
											WHEN COUNT(psExclusivo.iId) > 0
						                    THEN MAX(ss.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteExclusivo'',
									pe.sApellidoPaterno as sApellidoPaterno,
									pe.sApellidoMaterno as sApellidoMaterno,
									pe.sNombres as sNombres,
									pe.sDni as sDni,
									CASE WHEN TIMEDIFF(now(),so.dFechaPedido) > CAST(''01:00:00'' AS TIME) THEN 1 ELSE 0 END AS iSolicitudPasada,
									DATE_FORMAT(so.dFechaPedido,''%Y-%m-%d'') as dFechaPedido,
									DATE_FORMAT(so.dFechaPedido,''%T'') as dHoraPedido,
									c.sDescripcion as sCliente
						 from		cliente c
						inner join  usuariocliente uc
						on 			c.iId = uc.iIdCliente
						inner join	solicitud so
						on			so.iIdUsuarioCliente = uc.iId
						inner join 	persona pe
						on			pe.iId = so.iIdPersona
						inner join	solicituddetalle sd
						on			so.iId = sd.iIdSolicitud
						right join 	servicio se
						on			sd.iIdServicio = se.iId
						left join 	paqueteservicio psSelectivo
						on			psSelectivo.iIdServicio = sd.iIdServicio and psSelectivo.iIdPaquete in (select pp.iId from paquete pp where pp.iIdTipoPaquete = 3)
						left join 	paqueteservicio psExclusivo
						on			psExclusivo.iIdServicio = sd.iIdServicio and psExclusivo.iIdPaquete in (select ppp.iId from paquete ppp where ppp.iIdTipoPaquete = 2)
						left join 	servicio ss
						on			ss.iId = psExclusivo.iIdServicio
						left join	paquete p
						on			p.iId = sd.iIdPaquete and p.iIdTipoPaquete = 1
						where 		c.iId = ".$iIdCliente."
						and 		(IFNULL(so.sInforme,'''') = '''' AND IFNULL(so.sAnexo,'''') = '''')
						group by so.iId
						order by so.iId desc');

						set @query = REPLACE(@query, '\n', ' ');

						PREPARE stmt1 FROM @query;
						EXECUTE stmt1;
						DEALLOCATE PREPARE stmt1; ";



			$query = preg_replace("[\n|\r|\n\r]", ' ' , $query);

			return $query;


		}

		public function ListarSolicitudesPorResponderQuery(){

			$query = "	SET @sql = NULL;
						SELECT
						  GROUP_CONCAT(DISTINCT
						    CONCAT(
						      'CASE WHEN ISNULL(MAX(IF(se.sDescripcion = ''',
						      se.sDescripcion,
						      ''',psSelectivo.iId, NULL))) THEN '''' ELSE 1 END AS ''',
							  se.sDescripcion,''''
						    )
						  ) INTO @sql
						FROM servicio se
						inner join paqueteservicio ps
						on 	se.iId = ps.iIdServicio
						inner join paquete p
						on p.iId= ps.iIdPaquete
						where p.iIdTipoPaquete = 3;

						set @query = concat('select 		so.iId as iIdSolicitud,
									CASE
											WHEN COUNT(p.iId) > 0
											THEN MAX(p.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteInclusivo'','
						            ,@sql,',
						            CASE
											WHEN COUNT(psExclusivo.iId) > 0
						                    THEN MAX(ss.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteExclusivo'',
									pe.sApellidoPaterno as sApellidoPaterno,
									pe.sApellidoMaterno as sApellidoMaterno,
									pe.sNombres as sNombres,
									pe.sDni as sDni,
									DATE_FORMAT(so.dFechaPedido,''%Y-%m-%d'') as dFechaPedido,
									DATE_FORMAT(so.dFechaPedido,''%T'') as dHoraPedido,
									IFNULL(so.sInforme,'''') as Informe,
									IFNULL(so.sAnexo,'''') as OtrosDatos,
									c.sDescripcion as sCliente,
									c.iId as iIdCliente
						 from		cliente c
						inner join  usuariocliente uc
						on 			c.iId = uc.iIdCliente
						inner join	solicitud so
						on			so.iIdUsuarioCliente = uc.iId
						inner join 	persona pe
						on			pe.iId = so.iIdPersona
						inner join	solicituddetalle sd
						on			so.iId = sd.iIdSolicitud
						right join 	servicio se
						on			sd.iIdServicio = se.iId
						left join 	paqueteservicio psSelectivo
						on			psSelectivo.iIdServicio = sd.iIdServicio and psSelectivo.iIdPaquete in (select pp.iId from paquete pp where pp.iIdTipoPaquete = 3)
						left join 	paqueteservicio psExclusivo
						on			psExclusivo.iIdServicio = sd.iIdServicio and psExclusivo.iIdPaquete in (select ppp.iId from paquete ppp where ppp.iIdTipoPaquete = 2)
						left join 	servicio ss
						on			ss.iId = psExclusivo.iIdServicio
						left join	paquete p
						on			p.iId = sd.iIdPaquete and p.iIdTipoPaquete = 1
						where 		(IFNULL(so.sInforme,'''') = '''' AND IFNULL(so.sAnexo,'''') = '''')
						group by so.iId
						order by so.iId desc');

						set @query = REPLACE(@query, '\n', ' ');

						PREPARE stmt1 FROM @query;
						EXECUTE stmt1;
						DEALLOCATE PREPARE stmt1; ";



			$query = preg_replace("[\n|\r|\n\r]", ' ' , $query);

			return $query;


		}

		public function ListarSolicitudesRespondidasQuery($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

			$query = "	SET @sql = NULL;
						SELECT
						  GROUP_CONCAT(DISTINCT
						    CONCAT(
						      'CASE WHEN ISNULL(MAX(IF(se.sDescripcion = ''',
						      se.sDescripcion,
						      ''',psSelectivo.iId, NULL))) THEN '''' ELSE 1 END AS ''',
							  se.sDescripcion,''''
						    )
						  ) INTO @sql
						FROM servicio se
						inner join paqueteservicio ps
						on 	se.iId = ps.iIdServicio
						inner join paquete p
						on p.iId= ps.iIdPaquete
						where p.iIdTipoPaquete = 3;

						set @query = concat('select 		so.iId as iIdSolicitud,
									CASE
											WHEN COUNT(p.iId) > 0
											THEN MAX(p.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteInclusivo'','
						            ,@sql,',
						            CASE
											WHEN COUNT(psExclusivo.iId) > 0
						                    THEN MAX(ss.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteExclusivo'',
									pe.sApellidoPaterno as sApellidoPaterno,
									pe.sApellidoMaterno as sApellidoMaterno,
									pe.sNombres as sNombres,
									pe.sDni as sDni,
									DATE_FORMAT(so.dFechaPedido,''%Y-%m-%d'') as dFechaPedido,
									DATE_FORMAT(so.dFechaPedido,''%T'') as dHoraPedido,
									IFNULL(so.sInforme,'''') as Informe,
									IFNULL(so.sAnexo,'''') as OtrosDatos,
									c.sDescripcion as sCliente
						 from		cliente c
						inner join  usuariocliente uc
						on 			c.iId = uc.iIdCliente
						inner join	solicitud so
						on			so.iIdUsuarioCliente = uc.iId
						inner join 	persona pe
						on			pe.iId = so.iIdPersona
						inner join	solicituddetalle sd
						on			so.iId = sd.iIdSolicitud
						right join 	servicio se
						on			sd.iIdServicio = se.iId
						left join 	paqueteservicio psSelectivo
						on			psSelectivo.iIdServicio = sd.iIdServicio and psSelectivo.iIdPaquete in (select pp.iId from paquete pp where pp.iIdTipoPaquete = 3)
						left join 	paqueteservicio psExclusivo
						on			psExclusivo.iIdServicio = sd.iIdServicio and psExclusivo.iIdPaquete in (select ppp.iId from paquete ppp where ppp.iIdTipoPaquete = 2)
						left join 	servicio ss
						on			ss.iId = psExclusivo.iIdServicio
						left join	paquete p
						on			p.iId = sd.iIdPaquete and p.iIdTipoPaquete = 1
						where 		(NOT ISNULL(so.sInforme) or NOT ISNULL(so.sAnexo))
						AND 		c.iId = ".$iIdCliente."
						and         (
										(
										''".$sDni."'' <> ''''
										and
										''".$sDni."'' = pe.sDni
										)
									or  (
										''".$sDni."'' = ''''
										and
										pe.sApellidoPaterno like ''".$sApellidoPaterno."%''
										and
										pe.sApellidoMaterno like ''".$sApellidoMaterno."%''
										and
										pe.sNombres like ''".$sNombres."%''
										)
									)
						group by so.iId
						order by so.iId desc
						LIMIT 200');

						set @query = REPLACE(@query, '\n', ' ');

						PREPARE stmt1 FROM @query;
						EXECUTE stmt1;
						DEALLOCATE PREPARE stmt1; ";

			$query = preg_replace("[\n|\r|\n\r]", ' ' , $query);

			return $query;


		}

/*cambiar aqui ************************************/
		public function ListarSolicitudesHistoricasQuery($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){
			
			$iIdCliente += 0;

			$query = "	SET @sql = NULL;
						SELECT
						  GROUP_CONCAT(DISTINCT
						    CONCAT(
						      'CASE WHEN ISNULL(MAX(IF(se.sDescripcion = ''',
						      se.sDescripcion,
						      ''',psSelectivo.iId, NULL))) THEN '''' ELSE 1 END AS ''',
							  se.sDescripcion,''''
						    )
						  ) INTO @sql
						FROM servicio se
						inner join paqueteservicio ps
						on 	se.iId = ps.iIdServicio
						inner join paquete p
						on p.iId= ps.iIdPaquete
						where p.iIdTipoPaquete = 3;

						set @query = concat('select 		so.iId as iIdSolicitud,
									CASE
											WHEN COUNT(p.iId) > 0
											THEN MAX(p.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteInclusivo'','
						            ,@sql,',
						            CASE
											WHEN COUNT(psExclusivo.iId) > 0
						                    THEN MAX(ss.sDescripcion)
						                    ELSE ''''
									END AS ''sPaqueteExclusivo'',
									pe.sApellidoPaterno as sApellidoPaterno,
									pe.sApellidoMaterno as sApellidoMaterno,
									pe.sNombres as sNombres,
									pe.sDni as sDni,
									DATE_FORMAT(so.dFechaPedido,''%Y-%m-%d'') as dFechaPedido,
									DATE_FORMAT(so.dFechaPedido,''%T'') as dHoraPedido,
									IFNULL(so.sInforme,'''') as Informe,
									IFNULL(so.sAnexo,'''') as OtrosDatos,
									c.sDescripcion as sCliente
						 from		cliente c
						inner join  usuariocliente uc
						on 			c.iId = uc.iIdCliente
						inner join	solicitud so
						on			so.iIdUsuarioCliente = uc.iId
						inner join 	persona pe
						on			pe.iId = so.iIdPersona
						inner join	solicituddetalle sd
						on			so.iId = sd.iIdSolicitud
						right join 	servicio se
						on			sd.iIdServicio = se.iId
						left join 	paqueteservicio psSelectivo
						on			psSelectivo.iIdServicio = sd.iIdServicio and psSelectivo.iIdPaquete in (select pp.iId from paquete pp where pp.iIdTipoPaquete = 3)
						left join 	paqueteservicio psExclusivo
						on			psExclusivo.iIdServicio = sd.iIdServicio and psExclusivo.iIdPaquete in (select ppp.iId from paquete ppp where ppp.iIdTipoPaquete = 2)
						left join 	servicio ss
						on			ss.iId = psExclusivo.iIdServicio
						left join	paquete p
						on			p.iId = sd.iIdPaquete and p.iIdTipoPaquete = 1
						where 		(NOT ISNULL(so.sInforme) or NOT ISNULL(so.sAnexo))
						AND 		(
										".$iIdCliente." = 0
									or 	
										c.iId = ".$iIdCliente."
									)
						AND
									(
										(
										''".$sDni."'' <> ''''
										and
										''".$sDni."'' = pe.sDni
										)
									or  (
										''".$sDni."'' = ''''
										and
										pe.sApellidoPaterno like ''".$sApellidoPaterno."%''
										and
										pe.sApellidoMaterno like ''".$sApellidoMaterno."%''
										and
										pe.sNombres like ''".$sNombres."%''
										)
									)

						group by so.iId
						order by so.iId desc
						LIMIT 200');

						set @query = REPLACE(@query, '\n', ' ');

						PREPARE stmt1 FROM @query;
						EXECUTE stmt1;
						DEALLOCATE PREPARE stmt1; ";

			$query = preg_replace("[\n|\r|\n\r]", ' ' , $query);
			
			return $query;


		}

		public function CrearSolicitudMasivoQuery($iIdUsuario, $solicitudes){

			$query = "CALL CrearSolicitudMasivo(".$iIdUsuario.", '".$solicitudes."');";

			return $query;

		}

		/*public function ListarSolicitudesRespondidasQuery($iIdCliente){

			$sql = "SELECT ";
			$sql .= "so.iId as CodigoSolicitud, ";
			$sql .= "DATE_FORMAT(so.dFechaPedido,'%Y-%m-%d') as FechaPedido, ";
			$sql .= "DATE_FORMAT(so.dFechaPedido,'%T') as HoraPedido,";
			$sql .= "pe.sDni as Dni, ";
			$sql .= "pe.sApellidoPaterno as ApellidoPaterno, ";
			$sql .= "pe.sApellidoMaterno as ApellidoMaterno, ";
			$sql .= "pe.sNombres as Nombres, ";
			$sql .= "cl.sDescripcion as Cliente, ";
			$sql .= "IFNULL(so.sInforme,'') as Informe, ";
			$sql .= "IFNULL(so.sAnexo,'') as OtrosDatos ";
			$sql .= "FROM ";
			$sql .= "solicitud so ";
			$sql .= "INNER JOIN ";
			$sql .= "persona pe ON so.iIdPersona = pe.iId ";
			$sql .= "INNER JOIN ";
			$sql .= "usuariocliente uc ON so.iIdUsuarioCliente = uc.iId ";
			$sql .= "INNER JOIN ";
			$sql .= "cliente cl ON uc.iIdCliente = cl.iId ";
			$sql .= "WHERE (NOT ISNULL(so.sInforme) or NOT ISNULL(so.sAnexo)) ";
			$sql .= "AND cl.iId =".$iIdCliente.";";

			return $sql;

		}*/


		/*public function ListarSolicitudesHistoricasQuery($iIdCliente, $dFechaDesde, $dFechaHasta){

			$sql = "SELECT ";
			$sql .= "so.iId as CodigoSolicitud, ";
			$sql .= "DATE_FORMAT(so.dFechaPedido,'%Y-%m-%d') as FechaPedido, ";
			$sql .= "DATE_FORMAT(so.dFechaPedido,'%T') as HoraPedido,";
			$sql .= "pe.sDni as Dni, ";
			$sql .= "pe.sApellidoPaterno as ApellidoPaterno, ";
			$sql .= "pe.sApellidoMaterno as ApellidoMaterno, ";
			$sql .= "pe.sNombres as Nombres, ";
			$sql .= "cl.sDescripcion as Cliente, ";
			$sql .= "IFNULL(so.sInforme,'') as Informe, ";
			$sql .= "IFNULL(so.sAnexo,'') as OtrosDatos ";

			$sql .= "FROM ";
			$sql .= "solicitud so ";
			$sql .= "INNER JOIN ";
			$sql .= "persona pe ON so.iIdPersona = pe.iId ";
			$sql .= "INNER JOIN ";
			$sql .= "usuariocliente uc ON so.iIdUsuarioCliente = uc.iId ";
			$sql .= "INNER JOIN ";
			$sql .= "cliente cl ON uc.iIdCliente = cl.iId ";
			$sql .= "WHERE (NOT ISNULL(so.sInforme) OR NOT ISNULL(so.sAnexo)) ";
			$sql .= "AND cl.iId =".$iIdCliente." AND DATEDIFF(so.dFechaPedido,'".$dFechaDesde.",')>=0 AND DATEDIFF(so.dFechaPedido,'".$dFechaHasta.",')<=0;";

			return $sql;

		}*/



		//---------------------------------------------------------------------------------

		public function CrearSolicitud($persona, $iIdUsuario, $iIdPaqueteInclusivo, $servicios){

			$personaDao = new PersonaDao();

			if ($personaDao->ExisteDniPersona($persona)) {

				$iIdPersona = $personaDao->GetIdPersonaByDni($persona);

			}else{

				if ($personaDao->CrearPersona($persona)) {

					$iIdPersona = $persona->GetId();

				}else{

					return -1;
				}
			}

			$sql = $this->InsertarSolicitudQuery($iIdUsuario, $iIdPersona);
			$sql .= " SET @iIdSolicitud = LAST_INSERT_ID();";
			$sql .= $this->InsertarServiciosInclusivosEnSolicitudParaCrearQuery($iIdPaqueteInclusivo);
			$sql .= $this->InsertarServiciosNoInclusivosEnSolicitudParaCrearQuery($servicios);

			return ConexionSQL::transaction_query($sql);

		}

		public function ListarSolicitudesPendientes($solicitud){

			$sql = $this->ListarSolicitudesPendientesQuery($solicitud);

			return ConexionSQL::get_json_rows_multi_query($sql);
		}



		public function EditarSolicitud($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios){

			$sql = $this->EditarSolicitudQuery($iIdSolicitud, $persona, $iIdPaqueteInclusivo, $servicios);

			return ConexionSQL::transaction_query($sql);

		}

		public function EliminarSolicitud($iIdSolicitud){

			$sql = $this->EliminarSolicitudQuery($iIdSolicitud);

			return ConexionSQL::transaction_query($sql);

		}

		public function ListarSolicitudesPorResponder(){

			$sql = $this->ListarSolicitudesPorResponderQuery();


			return ConexionSQL::get_json_rows_multi_query($sql);
		}

		public function CrearSolicitudMasivo($iIdUsuario, $solicitudes){

			$sql = $this->CrearSolicitudMasivoQuery($iIdUsuario, $solicitudes);

			return ConexionSQL::get_json_row($sql);

		}

		public function ListarSolicitudesRespondidas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

			$sql = $this->ListarSolicitudesRespondidasQuery($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);

			return ConexionSQL::get_json_rows_multi_query($sql);

		}

		public function ListarSolicitudesHistoricas($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno){

			$sql = $this->ListarSolicitudesHistoricasQuery($iIdCliente, $sDni, $sNombres, $sApellidoPaterno, $sApellidoMaterno);
			return ConexionSQL::get_json_rows_multi_query($sql);

		}

		public function ActualizarInforme($iIdSolicitud, $sInforme){

			$sql =  "UPDATE solicitud SET sInforme='".$sInforme."', dFechaInforme = CURDATE() ";
			$sql .= "WHERE iId = ".$iIdSolicitud.";";

			return ConexionSQL::ejecutar_idu($sql);
		}

		public function ActualizarAnexo($iIdSolicitud, $sAnexo){

			$sql =  "UPDATE solicitud SET sAnexo='".$sAnexo."', dFechaInforme = CURDATE()  ";
			$sql .= "WHERE iId = ".$iIdSolicitud.";";

			return ConexionSQL::ejecutar_idu($sql);
		}

		public function ListarDatosSolicitud($iIdSolicitud){

			$sql = $this->ListarDatosSolicitudQuery($iIdSolicitud);
			return ConexionSQL::get_json_row($sql);
		}


	}

 ?>
