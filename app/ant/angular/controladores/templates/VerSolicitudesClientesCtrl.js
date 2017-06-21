var app = angular.module('SaegApp.Template.VerSolicitudesClientesCtrl', []);

app.controller('VerSolicitudesClientesCtrl', ['$scope','$rootScope','Solicitudes','$uibModal','Cliente','$location', function($scope, $rootScope, Solicitudes,$uibModal, Cliente, $location){

	var cliente = {};

	var ListarCantidadSolicitudesClientes = function(){
		
		Cliente.ListarCantidadSolicitudesClientes().then(function(data){

			$scope.clientes = data;

		},function(error){

			console.log(error);

		});
	};

	$scope.VerSolicitudesDeCliente = function(iIdCliente){

		cliente.iId = iIdCliente;

		Cliente.setCliente(cliente);

		$location.path('/ResponderSolicitudes');

	}

	ListarCantidadSolicitudesClientes();

}])
.directive('solicitudesclientesdirective',function(){
	return{
		templateUrl: 'template/VerSolicitudesClientes.html'
	}
})
