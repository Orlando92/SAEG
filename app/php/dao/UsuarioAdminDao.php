<?php  
	
	require_once("../db/ConexionSQL.php");
	require_once("../model/UsuarioAdmin.php");

	class UsuarioAdminDao{

		public function CrearUsuarioAdmin($usuarioAdmin){

			$sql = "
					SELECT 	COUNT(*) as existe
					FROM 	usuario
					WHERE 	sCorreo = '".$usuarioAdmin->GetCorreo()."'
					";

			$existe = ConexionSQL::get_valor_query($sql, 'existe');

			if ($existe > 0) {
				return -2; # Ya existe correo
			}

			$passwordEncriptada = ConexionSQL::crypt_blowfish($usuarioAdmin->GetPassword());

			$sql = "INSERT INTO persona(sApellidoPaterno, sApellidoMaterno, sDni, sNombres) VALUES('".$usuarioAdmin->GetApellidoPaterno()."','".$usuarioAdmin->GetApellidoMaterno()."','".$usuarioAdmin->GetDni()."','".$usuarioAdmin->GetNombres()."');"; 
			$sql.= "SET @id = LAST_INSERT_ID();";
			$sql.= "INSERT INTO usuario(iId,sCorreo,sPassword,iIdTipoUsuario,iActivo) VALUES(@id,'".$usuarioAdmin->GetCorreo()."','".$passwordEncriptada."',".$usuarioAdmin->GetIdTipoUsuario().",1);";
			$sql.= "INSERT INTO usuarioadmin(iId) VALUES(@id);";

			echo $sql;

			$resultado = ConexionSQL::ejecutar_idu($sql);

			return $resultado;



		}

	}

?>