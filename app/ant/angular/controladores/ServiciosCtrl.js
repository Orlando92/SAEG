var app = angular.module('facturacionApp.ServiciosCtrl', []);

// ================================================
//   Controlador de solicitudes individuales
// ================================================
app.controller('ServiciosCtrl', ['$scope','$rootScope','Servicios', function($scope, $rootScope, Servicios){


	$scope.activar('mDashboard','','Dashboard','información');
		

	$scope.listaServicios = {};


	Servicios.ListarServiciosActivos().then(function(data){
		$scope.listaServicios = data;
	});





}]);	