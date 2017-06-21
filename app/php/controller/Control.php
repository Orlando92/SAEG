<?php  
	
	class Control{

		static function encriptar($cadena){
		    $key='123456';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
		    return $encrypted; //Devuelve el string encriptado
		 
		}
		 
		static function desencriptar($cadena){
		    $key='123456';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		    return $decrypted;  //Devuelve el string desencriptado
		}

		public static function generateValidXmlFromObj(stdClass $obj, $node_block='nodes', $node_name='node') {
	        $arr = get_object_vars($obj);
	        return self::generateValidXmlFromArray($arr, $node_block, $node_name);
	    }

	    public static function generateValidXmlFromArray($array, $node_block='nodes', $node_name='node') {
	        $xml = '';

	        $xml .= '<' . $node_block . '>';
	        $xml .= self::generateXmlFromArray($array, $node_name);
	        $xml .= '</' . $node_block . '>';

	        return $xml;
	    }

	    private static function generateXmlFromArray($array, $node_name) {
	        $xml = '';

	        if (is_array($array) || is_object($array)) {
	            foreach ($array as $key=>$value) {
	                if (is_numeric($key)) {
	                    $key = $node_name;
	                }

	                $xml .= '<' . $key . '>' . self::generateXmlFromArray($value, $node_name) . '</' . $key . '>';
	            }
	        } else {
	            $xml = htmlspecialchars($array, ENT_QUOTES);
	        }

	        return $xml;
	    }
	}

?>