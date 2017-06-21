var app = angular.module('facturacionApp.GenerarSolicitudPersonalCtrl', []);

// ================================================
//   Controlador de solicitudes individuales
// ================================================
app.controller('GenerarSolicitudPersonalCtrl', ['$scope','$rootScope','Solicitudes', function($scope, $rootScope, Solicitudes){

	$scope.activar('mDashboard','','Registrar solicitud','Registro individual');

	$scope.mostrarSolicitud = false;

	$scope.$watch('mostrarSolicitud', function(){

		$scope.nombreBtnSolicitud = $scope.mostrarSolicitud ? 'Ocultar Formulario' : 'Registrar Solicitud';
		
	});

	$scope.mostrarOcultarSolicitud = function(){
		$scope.mostrarSolicitud = !$scope.mostrarSolicitud;
	};

}]);	