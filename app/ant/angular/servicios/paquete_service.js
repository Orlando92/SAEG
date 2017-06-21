var app = angular.module('SaegApp.paquete',[]);

app.factory('Paquete', ['Promesa',function(Promesa){

	var url = '../php/ws/PaqueteWS.php';

	var self = {

		ListarPaquetesActivos : function(){

			data = {};

			return Promesa.getPromise('ListarPaquetesActivos', data, url);
		},

		ListarPaquetesPorTipoPaquete: function(paquetes,tipoPaquete){

			paquetesPorTipoPaquete = [];

			for (var i = paquetes.length - 1; i >= 0; i--) {
				
				var paquete = angular.copy(paquetes[i]);

				if (paquete.iIdTipoPaquete == tipoPaquete) {

					paquetesPorTipoPaquete.push(paquete);

				}
			}

			return paquetesPorTipoPaquete;

		},

		ListarPaqueteInclusivoSeleccionado: function(paquetes){

			objeto = {};

			for (var i = paquetes.length - 1; i >= 0; i--) {
				
				var paquete = angular.copy(paquetes[i]);
				if (paquete.iSeleccionado == 1) {
					return paquete;
				}
			}

			return objeto;
		}		
	}

	return self

}])