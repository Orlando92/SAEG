
var app = angular.module('saegApp.session_provider', []);

app.provider('Session',function(){

	this.$get = function($http, $q){

		return{

			IsLogged: function(){

				var defered = $q.defer();
		        var promise = defered.promise;
		        var funcion = 'IsLogged';
		        var parameter = { 
		        					"funcion":funcion
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
			},

			DestroySession: function(){

				var defered = $q.defer();
		        var promise = defered.promise;
		        var funcion = 'DestroySession';
		        var parameter = { 
		        					"funcion":funcion
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

			},

			GetObjectSession: function(objectName){

				var defered = $q.defer();
		        var promise = defered.promise;
		        var funcion = 'GetObjectSession';
				var data = {
		        	objectName : objectName
		        }

		        var parameter = { 
		        					funcion : funcion,
		        					datos : data 
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
			}

		}		

	}

});

app.config(['SessionProvider',function(SessionProvider){

}]);
