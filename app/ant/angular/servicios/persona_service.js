var app = angular.module('SaegApp.persona',[]);

app.factory('Persona',['Promesa', function(Promesa){

    var url = '../php/ws/PersonaWS.php';

	var self = {

		ListarPersonaByDni: function(dni){

			 var data = {
            	dni : dni
        	}

        	return Promesa.getPromise('ListarPersonaByDni', data, url );
		}		
	}

	return self;

}]);