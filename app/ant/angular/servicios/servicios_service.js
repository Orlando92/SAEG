var app = angular.module('facturacionApp.servicios',[]);


app.factory('Servicios', ['Usuario','Promesa', function(Usuario, Promesa){

	var url = '../php/ws/ServiciosWS.php';
	
	var self = {
		
		listarServiciosActivos : function(){
	
			var defered = $q.defer();
	        var promise = defered.promise;
	        var funcion = 'ListarServiciosActivos';
	        var parameter = { 
	        					funcion : funcion
	        				};

	        $http({
	            method: 'POST',
	            url: '../php/ws/ServiciosWS.php',
	            data: angular.toJson(parameter),
	            headers: {
	                'Content-Type': 'application/json; charset=utf-8',
	                'Data-Type': 'json',
	            }
	        }).success(function (data, status, headers, config) {
	            defered.resolve(data);
	        }).error(function (data, status, headers, config) {
	            defered.reject(status);
	        });

	        return promise;

		},

		ListarServiciosActivosByIdPaquete: function(iIdPaquete){

			data = {
				iIdPaquete : iIdPaquete
			}

			return Promesa.getPromise('ListarServiciosActivosByIdPaquete', data, url);

		}, 

		ListarServiciosPaquetes: function(servicios,paquetes){

			serviciosTotal = {};

			serviciosDePaquete = [];			

			serviciosRestantes = [];

			for (var i = paquetes.length - 1; i >= 0; i--) {
				
				var paquete = angular.copy(paquetes[i]);

				for (var j = servicios.length - 1; j >= 0; j--) {

					var servicio = angular.copy(servicios[j]);
					
					if (servicio.iIdPaquete == paquete.iId) {

						serviciosDePaquete.push(servicio);
					
					}else{

						serviciosRestantes.push(servicio);					
					}

				} 

				serviciosTotal[paquete.iId] = serviciosDePaquete;

				servicios = serviciosRestantes;

				serviciosRestantes = [];

				serviciosDePaquete = [];

			}

			return serviciosTotal;

		}


	}

	return self;
}]);