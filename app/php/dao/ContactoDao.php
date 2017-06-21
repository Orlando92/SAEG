<?php  

	include_once('../db/ConexionSQL.php');
	include_once('../model/Contacto.php');

	/**
	* 
	*/
	class ContactoDao
	{

		public function getContactoById($iId){
			
			$sql = 	"SELECT P.iId, P.sApellidoPaterno, P.sApellidoMaterno, P.sNombres, P.sDni, C.sEmail, C.sTelefono";
			$sql .=	"FROM contacto C";
			$sql .=	"INNER JOIN persona P";
			$sql .=	"ON C.iId = P.iId";
			$sql .=	"WHERE C.iId = '".$iId."'";

			$row = ConexionSQL::get_row($sql);

			if (!empty($row)) {
				$contacto = new Contacto();
				$contacto -> SetId((int)$row['iId']);
				$contacto -> SetApellidoPaterno($row['sApellidoPaterno']);
				$contacto -> SetApellidoMaterno($row['sApellidoMaterno']);
				$contacto -> SetNombres($row['sNombres']);
				$contacto -> SetDni($row['sDni']);
				$contacto -> SetEmail($row['sEmail']);
				$contacto -> SetTelefono($row['sTelefono']);

				return $contacto;
			}
				
			return null;
		}
	}


?>