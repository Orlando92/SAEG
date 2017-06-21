var app = angular.module('SaegApp.usuario',[]);

app.factory('Usuario',['$http', '$q','Promesa', function($http, $q, Promesa){

	var usuario  = {};

	var imgUsuario = '';

	var sTipoUsuario = '';

    var url = '../php/ws/SessionWS.php';

    var urlUsuario = '../php/ws/UsuarioWS.php';

	var cargarUsuario = function(){

        var data = {
            objectName : 'usuario'
        }

        return Promesa.getPromise('GetObjectSession', data, url );
		
    };

	var self = {

		cargarUsuario: function(){

			 var data = {
            objectName : 'usuario'
        	}

        	return Promesa.getPromise('GetObjectSession', data, url );

		},

		setUsuario: function(value){

			usuario = value;

		},

		getTipoUsuario: function(){

			return sTipoUsuario;

		},

		getImgUsuario: function(){
			
			return imgUsuario;

		},

		getUsuario: function(){
			return usuario;
		}, 

		setImgUsuario : function(){

	    	switch(usuario.iIdTipoUsuario){

	    		case 3:

	    			imgUsuario = 'dist/img/cliente.jpg';
	    			sTipoUsuario = 'Cliente';
	    			

	    			break;


	    		case 5:

	    			imgUsuario = 'dist/img/operacion.jpg';
	    			sTipoUsuario = 'Operacion';

	    			break;

    		}
    	},

    	CambiarPassword :  function(passwordActual, passwordNueva){
    		var data = {
    			passwordActual: passwordActual,
    			passwordNueva: passwordNueva
    		}

    		return Promesa.getPromise('CambiarPassword', data, urlUsuario );

    	}


	}

	return self;

}]);