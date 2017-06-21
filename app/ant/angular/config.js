
// ================================================
//   Rutas
// ================================================

var app = angular.module('saegApp.route_config', []);

app.config(['$routeProvider', function($routeProvider){

	$routeProvider

		.when('/Inicio',{

			templateUrl: 'parciales/Inicio.html',

			controller: 'InicioCtrl'

		})

		.when('/VerSolicitudesRespondidas',{

			templateUrl: 'parciales/Solicitud.html'  ,

			controller: 'VerSolicitudesRespondidasCtrl'

		})
		.when('/GenerarSolicitudPersonal',{

			templateUrl: 'parciales/GenerarSolicitudPersonal.html',

			controller: 'GenerarSolicitudPersonalCtrl'

		})
		.when('/GenerarSolicitudMasivo',{

			templateUrl: 'parciales/GenerarSolicitudMasivo.html' ,

			controller: 'GenerarSolicitudMasivoCtrl'

		})
		.when('/ResponderSolicitudes',{

			templateUrl: 'parciales/ResponderSolicitudes.html' ,

			controller: 'ResponderSolicitudesCtrl'

		})
		.when('/ReporteHistoricos',{

			templateUrl: 'parciales/ReporteHistoricos.html' ,

			controller: 'ReporteHistoricosCtrl'

		})
		.when('/ResponderSolicitud',{
			templateUrl: 'parciales/ResponderSolicitud.html',
			controller: 'ResponderSolicitudCtrl'
		})
		.otherwise({
			redirectTo: '/Inicio'
		});






}]);
