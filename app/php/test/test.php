<?php  
require_once("../db/ConexionSQL.php");
require_once("../rest/SolicitudDetalleRestHandler.php");
require_once("../rest/SolicitudRestHandler.php");
require_once("../rest/PersonaRestHandler.php");
require_once("../Controller/IniciarSesionCtrl.php");
require_once("../rest/UsuarioRestHandler.php");



$data = json_decode('{"funcion":"IngresarInformacionServicioPersona","datos":{"iIdPersona":"1","iIdServicio":"1","detalle":[{"camposServicio":[{"iId":"1","sDescripcion":"Delito","sValor":"asdasd"},{"iId":"2","sDescripcion":"Dependencia","sValor":"asdasdas"},{"iId":"3","sDescripcion":"Nro. de Oficio","sValor":"dasdasd"},{"iId":"5","sDescripcion":"Situacion","sValor":"asdasdasdas"}],"dFecha":"2017-06-07T05:00:00.000Z"},{"camposServicio":[{"iId":"1","sDescripcion":"Delito","sValor":"asdasd"},{"iId":"2","sDescripcion":"Dependencia","sValor":"asdasdas"},{"iId":"3","sDescripcion":"Nro. de Oficio","sValor":"dasdasd"},{"iId":"5","sDescripcion":"Situacion","sValor":"asdasdasdas"}],"dFecha":"2017-06-07T05:00:00.000Z"}]}}'); 

echo $data->funcion;

$datos = $data->datos;

$detalle = $datos->detalle;

$objetoDetalle = $detalle[0];

echo $objetoDetalle->dFecha;

$camposServicio = $objetoDetalle->camposServicio; 

$campoServicio = $camposServicio[0];

echo $campoServicio->sDescripcion;



?>