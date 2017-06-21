var app = angular.module('SaegApp.promesa',[]);

app.service('Promesa',['$http','$q',function($http,$q){

	this.getPromise = function(funcion, datos, url){

		var defered = $q.defer();
        var promise = defered.promise;

        var parameter = { 
        					funcion : funcion,
        					datos : datos 
        				};

        $http({
            method: 'POST',
            url: url,
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

    this.getPromiseFile = function(fd, url){

        var defered = $q.defer();
        var promise = defered.promise;
        
        $http.post(url, fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
        }).success(function (data, status, headers, config) {                       
            defered.resolve(data);
        }).error(function (data, status, headers, config) {
            defered.reject(status);
        });

        return promise;
    };

}])