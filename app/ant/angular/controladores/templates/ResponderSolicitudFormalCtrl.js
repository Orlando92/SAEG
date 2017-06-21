app.controller('ResponderSolicitudFormalCtrl', ['$scope','Solicitudes','Util','$location','$uibModal','iIdSolicitud','SolicitudDetalle',
 function($scope, Solicitudes,Util, $location, $uibModal, iIdSolicitud, SolicitudDetalle){
	
	/* Objetos del DOM */

	$scope.servicios = [];
	$scope.datosSolicitud = {};
	
	/* Funciones del Scope */

	$scope.eventos = {};

	$scope.eventos.manejarResponderServicio = function(servicio){
		console.log(servicio);

		if (!Util.isUndefinedOrNullOrEmpty(servicio.iExiste)) {

			swal(
				  'Oops...',
				  'Este servicio ya fue respondido',
				  'info'
			);

		}

		var modalResponderServicio =  $uibModal.open({
			animation: true, 
			ariaLabelledBy: 'modal-title',
 			ariaDescribedBy: 'modal-body',
 			size: 'lg',
  			templateUrl: 'modal/ResponderServicio.html',
  			controller: 'ResponderServicioCtrl',
  			resolve: {
  				datosServicio: function(){
  					return {
  						iIdServicio: servicio.iId,
  						iIdPersona: $scope.datosSolicitud.iIdPersona, 
  						iIdSolicitudDetalle: servicio.iIdSolicitudDetalle
  					};
  				}, 

  			}
		});

		modalResponderServicio.closed.then(function () {

    	});

		

	}


	/* Funciones locales */

	var ListarDatosInterface = function(iIdSolicitud){

		if (Util.isUndefinedOrNullOrEmpty(iIdSolicitud) || iIdSolicitud == 0) {

			swal(
				  'Oops...',
				  'Hubo un problema. Inténtelo nuevamente.',
				  'error'
			);

		}

		Solicitudes.ListarDatosSolicitud(iIdSolicitud).then(function(data){

			if (!Util.isUndefinedOrNullOrEmpty(data)) {

				$scope.datosSolicitud = data;

			}

		});

		SolicitudDetalle.ListarServiciosByIdSolicitud(iIdSolicitud).then(function(data){

			if (!Util.isUndefinedOrNullOrEmpty(data)) {

				$scope.servicios = data;

			}else{

				swal(
				  'Oops...',
				  'Hubo un problema. Inténtelo nuevamente.',
				  'error'
				);

			}


		},function(error){

			swal(
			  'Oops...',
			  'Hubo un problema. Inténtelo nuevamente.',
			  'error'
			);
		});

	};

	ListarDatosInterface(iIdSolicitud);

	


}])