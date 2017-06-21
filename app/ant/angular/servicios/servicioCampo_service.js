app.factory('ServicioCampo', ['Promesa', function(Promesa){

	url = '../php/ws/ServicioCampoWS.php';

	var self = {

		ListarServicioCampos: function(iIdServicio){

			var data = {

				iIdServicio: iIdServicio

			};

			return Promesa.getPromise('ListarServicioCampos', data, url);

		}

	};

	return self;


}])