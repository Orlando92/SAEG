app.factory('SolicitudDetalle', ['Promesa', function(Promesa){

	var url = '../php/ws/SolicitudDetalleWS.php'; 

	self = {

		ListarServiciosByIdSolicitud: function(iIdSolicitud){

			var data = {

				iIdSolicitud : iIdSolicitud
			}

			return Promesa.getPromise('ListarServiciosByIdSolicitud', data, url);

		}

	}

	return self;	
	
}]);