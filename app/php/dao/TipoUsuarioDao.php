<?php
	
	require_once('../db/ConexionSQL.php');
	require_once('../model/TipoUsuario.php');

	class TipoUsuarioDao{

		public function GetTipoUsuarioById($iId)
		{
			$sql = 	"SELECT iId,sDescripcion,iIdCategoria FROM tipousuario WHERE iId = ".$iId."";

			$row = ConexionSQL::get_row($sql);

			if (!empty($row)) {
				$tipoUsuario = new TipoUsuario();
				$tipoUsuario -> SetId((int)$row['iId']);
				$tipoUsuario -> SetDescripcion($row['sDescripcion']);
				$tipoUsuario -> SetIdCategoria((int)$row['iIdCategoria']);
				return $tipoUsuario;
			}
				
			return null;
		}			

	}
?>