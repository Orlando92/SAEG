<?php 

require_once("Controller\SolicitudCtrl.php");
require_once("rest/IniciarSesionRestHandler.php");
require_once("rest/SolicitudRestHandler.php");

$iniciarSesionRH = new IniciarSesionRestHandler();

$iniciarSesionRH->ValidarUsuario('gbueno@ejemplo.com','123456');

$solicitudRestHandler = new SolicitudRestHandler();

$solicitudRestHandler->ListarSolicitudesPorResponder();



/*

$json_persona = '{"OtraPropiedad" : "Valor de prueba", "sDni" : "33366699", "sNombres" : "Mery Angie", "sApellidoPaterno" : "Reinaga", "sApellidoMaterno" : "Ruiz"}';

//var_dump($json_persona);

$lista_servicio = '[{"iId" : "1", "sDescripcion" : "Policiales"},{"iId" : "2", "sDescripcion" : "Judiciales"},{"iId" : "3", "sDescripcion" : "Penales"}, {"iId" : "4", "sDescripcion" : "Terrorismo"},{"iId" : "5", "sDescripcion" : "Drogas"}]';

$usuario_cliente = '{"iId" : "7", "iIdCliente" : "1"}';
*/
/*$solicitud_Ctrl = new SolicitudCtrl();

echo "Ejecutando script... <br>";



echo $solicitud_Ctrl->ListarSolicitudesPendientes(7);*/

//$resultado = $solicitud_Ctrl->RegistrarSolicitudIndividual($json_persona, $lista_servicio, $usuario_cliente);

//echo "$resultado";

//var_dump($resultado);


//$p->GetNombres();
/*
private $iId;
	private $sDescripcion;
	private $iActivo;

$j = '[{"OtraPropiedad" : "Valor de prueba", "sDni" : "42204510", "sNombres" : "Cesar Antonio", "sApellidoPaterno" : "Gutierrez", "sApellidoMaterno" : "Lopez"}, {"OtraPropiedad" : "Valor de prueba2", "sDni" : "23232323", "sNombres" : "Luisa", "sApellidoPaterno" : "Medrano", "sApellidoMaterno" : "Gonzales"}]';*/

/*include_once("Model\Persona.php");
include_once("Model\Usuario.php");

$oPersona = new Persona();

$oPersona->SetNombres('CESAR ANTONIO');
$oPersona->SetId(1);
//$oPersona->SetId("dsds");

echo 'ID : '.$oPersona->GetId()."<br>";
echo 'Nombres : '.$oPersona->GetNombres();

echo "<br>";
echo "-----------------------------------------------------------";
echo "<br>";

$miUsuario = new Usuario();

$miUsuario = $oPersona;

echo 'ID : '.$miUsuario->GetId()."<br>";
echo 'Nombres : '.$miUsuario->GetNombres();

echo "<br>";
echo "-----------------------------------------------------------";
echo "<br>";

$oNuevaPersona = new Persona();

$oNuevaPersona = $miUsuario;

echo 'ID : '.$oNuevaPersona->GetId()."<br>";
echo 'Nombres : '.$oNuevaPersona->GetNombres();

require_once("Model\UsuarioAdmin.php");

require_once('Controller\CrearUsuarioCtrl.php');

$usuarioAdmin = new UsuarioAdmin(0,'Heredia','Carrasco','Orlando Mario','47564064','oheredia20122064@gmail.com','123',1);

$crearUsuarioCtrl = new CrearUsuarioCtrl();

echo $crearUsuarioCtrl->CrearUsuarioAdmin($usuarioAdmin);
*/
?>