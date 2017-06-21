var app = angular.module('login.loginService',[]);


app.factory('LoginService', ['$http','$q', function( $http, $q ){


	var self = {

		login: function( datos ){
			var defered = $q.defer();
	        var promise = defered.promise;
	        var funcion = 'ValidarUsuario';
	        var parameter = { 
	        					"funcion":funcion,
	        					"datos": datos 
	        				};

	        $http({
	            method: 'POST',
	            url: '../php/ws/IniciarSesionWS.php',
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

	};

	return self;

}])



