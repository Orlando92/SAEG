var app = angular.module('SaegApp.cliente',[]);

app.factory('Cliente',['Promesa', function(Promesa){

    var url = '../php/ws/ClienteWS.php';

    var cliente = {};

	var self = {

		getCliente : function(){
			return cliente;
		},

		setCliente: function(value){
			cliente = value;
		},

		ListarCantidadSolicitudesClientes: function(){

			 var data = {};

        	return Promesa.getPromise('ListarCantidadSolicitudesClientes', data, url );
		}, 

		ListarClientesActivos : function(){

			var data = {};

        	return Promesa.getPromise('ListarClientesActivos', data, url );
		}		
	}

	return self;

}]);