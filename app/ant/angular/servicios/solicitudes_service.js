var app = angular.module('facturacionApp.solicitudes',[]);


app.factory('Solicitudes', ['Usuario','Promesa', function(Usuario, Promesa){

	var url = '../php/ws/SolicitudWS.php';

	var flagEditarSolicitud = false;

	var solicitudAEditar = 0;

	var solicitudAResponder = 0;

	var self = {


		getSolicitudAEditar:function(){

			return solicitudAEditar;

		},

		setSolicitudAEditar: function(value){

			solicitudAEditar = value;
		},

		getSolicitudAResponder:function(){

			return solicitudAResponder;

		},

		setSolicitudAResponder: function(value){

			solicitudAResponder = value;
		},

		getFlagEditarSolicitud: function(){

			return flagEditarSolicitud;

		},

		setFlagEditarSolicitud: function(value){

			flagEditarSolicitud = value;
		},


		ListarSolicitudesPendientes: function(){

	        var data = {
	        	iIdUsuario : Usuario.getUsuario().iId
	        }

	        return Promesa.getPromise('ListarSolicitudesPendientes', data, url);

		},

		RegistrarSolicitudIndividual : function(persona, lista){

			var data = {

				persona: persona,
				lista: lista,
				iIdUsuario : Usuario.getUsuario().iId
			}

			return Promesa.getPromise('RegistrarSolicitudIndividual', data, url);

		},

		ListarSolicitudByiId: function(iId){

			var data = {
	        	iIdSolicitud : iId
	        };

	        return Promesa.getPromise('ListarSolicitudByiId', data, url);

		},

		EditarSolicitud: function(iId, persona, lista){

	        var data = {
	        	iIdSolicitud : iId,
	        	persona: persona,
	        	lista: lista
	        }

	        return Promesa.getPromise('EditarSolicitud', data, url);

		},

		EliminarSolicitud: function(iId){

	        var data = {

	        	iIdSolicitud : iId

	        }

	        return Promesa.getPromise('EliminarSolicitud', data, url);

		},

		ListarSolicitudDetalleParaRegistrar: function(iId){

			var data = {

	        }

	        return Promesa.getPromise('ListarSolicitudDetalleParaRegistrar', data, url);
		},

		ListarSolicitudDetalleParaEditar: function(iId){

			var data = {
	        	iIdSolicitud : iId
	        }

	        return Promesa.getPromise('ListarSolicitudDetalleParaEditar', data, url);

		},

		ListarServiciosByIdPaquete: function(servicios,iIdPaquete){

			lista = [];

			for (var i = servicios.length - 1; i >= 0; i--) {

				servicio = angular.copy(servicios[i]);

				if (servicio.iIdPaquete == iIdPaquete) {
					lista.push(servicio);
				}
			}

			return lista;
		},

		ListarServiciosSeleccionadosByIdPaquete : function (serviciosPaquete,iIdPaquete){

			array = [];

			if (angular.isUndefined(serviciosPaquete[0].iSeleccionado)) {

				return array;
			}

			for (var i = serviciosPaquete.length - 1; i >= 0; i--) {

				var servicio = serviciosPaquete[i]

				if (servicio.iSeleccionado == 1) {

					array.push(servicio);

				}

			}

			return array;
		},

		ListarPaquetesServiciosSeleccionados: function (paqueteInclusivoSeleccionado, serviciosDePaquetesSelectivosSeleccionados, serviciosDePaquetesExclusivosSeleccionados){

			lista = {
				paqueteInclusivoSeleccionado: paqueteInclusivoSeleccionado,
				servicios: []
			} ;

			servicios = [];

			servs = Object.keys(serviciosDePaquetesSelectivosSeleccionados);

			for (var i = servs.length - 1; i >= 0; i--) {
				var paq = Object.keys(serviciosDePaquetesSelectivosSeleccionados[servs[i]])[0];
				if (serviciosDePaquetesSelectivosSeleccionados[servs[i]][paq]) {
					var servicio = {};
					servicio.iId = servs[i];
					servicio.iIdPaquete = paq;
					servicios.push(servicio);
				}

			}

			paqs =  Object.keys(serviciosDePaquetesExclusivosSeleccionados);

			for (var i = paqs.length - 1; i >= 0; i--) {

				if (!angular.isUndefined(serviciosDePaquetesExclusivosSeleccionados[paqs[i]]) && serviciosDePaquetesExclusivosSeleccionados[paqs[i]] != null){

					var serv = serviciosDePaquetesExclusivosSeleccionados[paqs[i]].iId;
					var servicio = {};
					servicio.iId = serv;
					servicio.iIdPaquete = paqs[i];
					servicios.push(servicio);


				}
			}

			lista.servicios = servicios;

			return lista;
		},

		RegistrarSolicitudMasivo: function(solicitudes){

			var data = {

				solicitudes: solicitudes
			}

			return Promesa.getPromise('CrearSolicitudMasivo', data, url);

		},

		ListarSolicitudesPorResponder: function(){

			var data = { };

			return Promesa.getPromise('ListarSolicitudesPorResponder', data, url);
		},

		ListarSolicitudesRespondidas: function(formulario){

			var data = {

				sDni : formulario.sDni,
				sNombres: formulario.sNombres,
				sApellidoPaterno: formulario.sApellidoPaterno,
				sApellidoMaterno: formulario.sApellidoMaterno
	        }

			return Promesa.getPromise('ListarSolicitudesRespondidas', data, url);

		},

		ListarSolicitudesHistoricas: function(IdCliente, sDni, sNombres, sApellidoPaterno, sApellidoMaterno){

			var data = {
				IdCliente : IdCliente,
				Dni : sDni,
				Nombres : sNombres,
				ApellidoPaterno : sApellidoPaterno,
				ApellidoMaterno : sApellidoMaterno
			}

			return Promesa.getPromise('ListarSolicitudesHistoricas', data, url);

		}, 

		ListarDatosSolicitud: function(iIdSolicitud){

			var data = {
				iIdSolicitud : iIdSolicitud
			}

			return Promesa.getPromise('ListarDatosSolicitud', data, url);

		}
	}

	return self;

}]);
