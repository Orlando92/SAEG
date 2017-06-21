var app = angular.module('saegApp.acceso_provider', []);

app.provider('Acceso',function(){	

	this.$get = function($http, $q){

		return{

			getModulos: function(){

			var defered = $q.defer();
	        var promise = defered.promise;
	        var funcion = 'GetObjectSession';
	        var data = {
	        	objectName : 'modulos'
	        }
	        var parameter = { 
	        					funcion: funcion,
	        					datos: data
	        				};

	        $http({
	            method: 'POST',
	            url: '../php/ws/SessionWS.php',
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

			esModuloAutorizado : function(modulo){

				var defered = $q.defer();
		        var promise = defered.promise;
		        var funcion = 'EsModuloAutorizado';
		        var data = {
		        	sDescripcion : modulo
		        }
		        var parameter = { 
		        					funcion:funcion,
		        					datos: data
		        				};

		        $http({
		            method: 'POST',
		            url: '../php/ws/SessionWS.php',
		            data: JSON.stringify(parameter),
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
			}

		}
	}
});

app.config(['AccesoProvider',function(AccesoProvider){

}]);