app.factory('Informacion', ['Promesa','$filter', function(Promesa, $filter){
	
	var url = '../php/ws/InformacionWS.php'

	var self = {

		ListarInformacionServicioPersona: function(iIdPersona, iIdServicio){

			var data = {

				iIdPersona: iIdPersona, 
				iIdServicio: iIdServicio

			};

			return Promesa.getPromise('ListarInformacionServicioPersona', data, url);
		},

		IngresarInformacionServicioPersona: function(iIdSolicitudDetalle , iIdPersona, iExiste, iIdServicio, detalle){

			var data = {
				iIdSolicitudDetalle: iIdSolicitudDetalle,
				iIdPersona: iIdPersona, 
				iIdServicio: iIdServicio, 
				detalle: detalle,
				iExiste: iExiste ? 1 : 0 

			};

			return Promesa.getPromise('IngresarInformacionServicioPersona', data, url);
		}, 

		ListarCamposInformaciones: function(listaInformaciones){

			listaInformaciones = $filter('orderBy')(listaInformaciones,'iIdInformacion');

			ultimoIdInformacion = 0;

			camposInformaciones = [];

			var datos = {};

			var camposServicio = [];

			for(value in listaInformaciones){
				
				if (listaInformaciones[value].iIdInformacion != ultimoIdInformacion) {

					if (ultimoIdInformacion != 0) {

						datos.camposServicio = camposServicio;

						camposInformaciones.push(datos);

						datos = {};

						camposServicio = [];
					}					

					ultimoIdInformacion = listaInformaciones[value].iIdInformacion;

					datos.dFecha = listaInformaciones[value].dFechaInformacion; 
				}

				var campoServicio = {

					iId: listaInformaciones[value].iIdServicioCampo, 
					sDescripcion: listaInformaciones[value].sDescripcion, 
					sValor: listaInformaciones[value].sContenido
				}

				camposServicio.push(campoServicio);

			}

			datos.camposServicio = camposServicio; 

			camposInformaciones.push(datos);

			return $filter('orderBy')(camposInformaciones,'dFecha', true);
		}

	};

	return self;

}])