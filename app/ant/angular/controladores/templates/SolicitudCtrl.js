var app = angular.module('SaegApp.Template.SolicitudCtrl', []);

app.controller('SolicitudCtrl',['$scope','$rootScope','Solicitudes','Servicios', 'Paquete','Persona',function($scope, $rootScope, Solicitudes,Servicios, Paquete, Persona){

	//$scope.activar('mDashboard','','Registrar solicitud','Registro por formulario');

	$scope.solicitud = {
		persona : {

		},
		paquetes : [],
		servicios: [], 
		nombreBoton : ''
	};

	$scope.serviciosDePaquetesSelectivosSeleccionados = {

	};

	$scope.serviciosDePaquetesExclusivosSeleccionados = {

	};

	$scope.serviciosSelectivos = [];

	$scope.serviciosExclusivos = [];

	$scope.serviciosInclusivos = [];

	$scope.paquetesInclusivos = [];

	$scope.paqueteInclusivoSeleccionado = 0;

	$scope.serviciosSelectivosDePaquete = {

		iIdPaquete : 0,
		servicios : []
	};

	$scope.paquetesSelectivos = [];

	$scope.paquetesExclusivos = [];

	$scope.manejarEventoChangeDni = function(){

		if($scope.formSolicitud.dni.$valid){

			Persona.ListarPersonaByDni($scope.solicitud.persona.sDni).then(function(data){

				var persona = angular.fromJson(data);

				if (Object.keys(persona).length > 0) {

					//persona.sDni = parseInt(persona.sDni);
					$scope.solicitud.persona = persona;
					$scope.encuentraDni = true;
				}else{
					$scope.solicitud.persona.sNombres = '';
					$scope.solicitud.persona.sApellidoPaterno = '';
					$scope.solicitud.persona.sApellidoMaterno = '';
					$scope.encuentraDni = false;
				}

			},function(error){

				console.log(error);

			})

		}else{

			$scope.solicitud.persona = {
				iId: $scope.solicitud.persona.iId
			};

			$scope.encuentraDni = false;

		}

	}



	var cambiarServiciosPaqueteCompleto = function(serviciosInclusivos){

		var i = 0; 

		while(i < serviciosInclusivos[2].length){

			if (encuentraObjeto(serviciosInclusivos[1],serviciosInclusivos[2][i])) {

				serviciosInclusivos[2].splice(i,1);
				continue;
			
			}

			i++;
		}

		serviciosInclusivos[2].push({iId: 0, sDescripcion: "Antecedentes 1"});
	};

	var encuentraObjeto = function(servicios, objeto){

		for (var i = servicios.length - 1; i >= 0; i--) {
			
			if (servicios[i].iId == objeto.iId) {

				return true;
				
			}
			
		}

		return false;

	}

	var listarPaquetesYServicios = function(paquetesJson, serviciosJson){

		$scope.solicitud.paquetes = angular.fromJson(paquetesJson);

		$scope.solicitud.servicios = angular.fromJson(serviciosJson);

		$scope.paquetesInclusivos = Paquete.ListarPaquetesPorTipoPaquete($scope.solicitud.paquetes, 1);

		$scope.serviciosInclusivos = Servicios.ListarServiciosPaquetes($scope.solicitud.servicios, $scope.paquetesInclusivos);

		cambiarServiciosPaqueteCompleto($scope.serviciosInclusivos);
			
		$scope.paquetesSelectivos = Paquete.ListarPaquetesPorTipoPaquete($scope.solicitud.paquetes, 3);

		$scope.serviciosSelectivos = Servicios.ListarServiciosPaquetes($scope.solicitud.servicios, $scope.paquetesSelectivos);

		$scope.paquetesExclusivos = Paquete.ListarPaquetesPorTipoPaquete($scope.solicitud.paquetes, 2);

		$scope.serviciosExclusivos = Servicios.ListarServiciosPaquetes($scope.solicitud.servicios, $scope.paquetesExclusivos);

	};

	$scope.flagEditarSolicitud = Solicitudes.getFlagEditarSolicitud();

	$scope.crearEditarSolicitudIndividual = function(){

		var lista = Solicitudes.ListarPaquetesServiciosSeleccionados($scope.paqueteInclusivoSeleccionado, $scope.serviciosDePaquetesSelectivosSeleccionados, $scope.serviciosDePaquetesExclusivosSeleccionados);
		
		if (lista.paqueteInclusivoSeleccionado == 0 && lista.servicios.length == 0){

			swal('Oops!', 'Selecciona un servicio', 'warning');
			return;
		}

		if ($scope.flagEditarSolicitud) {

			Solicitudes.EditarSolicitud(Solicitudes.getSolicitudAEditar(), $scope.solicitud.persona, lista).then(function(data){
				if (!angular.isUndefined(data)) {
					
					if(data == 1){

						swal('Bien Hecho !', 'Se ha actualizado la solicitud correctamente', 'success');
						$scope.$parent.cancel();

					}else{

						swal('Error !', 'No se ha podido actualizar la solicitud', 'error');
					}

				}else{

					swal('Error de red !', 'Parece que no tiene internet', 'error');

				}	
			},function(error){
				console.log(error);
			});

		}else{
            
            if ($scope.solicitud.persona.sDni.length < 8){

				swal('Error !', 'El documento de identidad debe tener mínimo 8 dígitos', 'error');

				return;
			}
			
			Solicitudes.RegistrarSolicitudIndividual($scope.solicitud.persona, lista).then(function(data){

				if (!angular.isUndefined(data)) {
					
					if(data == 1){

						swal('Bien Hecho !', 'Se ha registrado la solicitud correctamente', 'success');
						$rootScope.ListarSolicitudesPendientes();
						document.getElementById("formSolicitud").reset();

					}else{

						swal('Error !', 'No se ha podido registrar la solicitud', 'error');
					}

				}else{

					swal('Error de red !', 'Parece que no tiene internet', 'error');

				}	
			},function(error){
				console.log(error);
			});

		}

	};


	if($scope.flagEditarSolicitud){

		$scope.solicitud.nombreBoton = 'Actualizar';

		Solicitudes.ListarSolicitudDetalleParaEditar(Solicitudes.getSolicitudAEditar()).then(function(data){
			if (data !=null) {
				$scope.solicitud.persona = angular.fromJson(data[0])[0];
				$scope.solicitud.persona.sDni = parseInt($scope.solicitud.persona.sDni);

				listarPaquetesYServicios(data[1], data[2]);

				var paqueteInclusivoSeleccionado = Paquete.ListarPaqueteInclusivoSeleccionado($scope.paquetesInclusivos);

				if (Object.keys(paqueteInclusivoSeleccionado).length != 0) {
					$scope.paqueteInclusivoSeleccionado = paqueteInclusivoSeleccionado.iId;
				}

				for (var i = $scope.paquetesSelectivos.length - 1; i >= 0; i--) {
					serviciosSeleccionados = Solicitudes.ListarServiciosSeleccionadosByIdPaquete($scope.serviciosSelectivos[$scope.paquetesSelectivos[i].iId],$scope.paquetesSelectivos[i].iId);
					for (var j = serviciosSeleccionados.length - 1; j >= 0; j--) {
						$scope.serviciosDePaquetesSelectivosSeleccionados[serviciosSeleccionados[j].iId] = {};
						$scope.serviciosDePaquetesSelectivosSeleccionados[serviciosSeleccionados[j].iId][serviciosSeleccionados[j].iIdPaquete] = true;
					}
				}

				for (var i = $scope.paquetesExclusivos.length - 1; i >= 0; i--) {
					$scope.serviciosDePaquetesExclusivosSeleccionados[$scope.paquetesExclusivos[i].iId] = 
					Solicitudes.ListarServiciosSeleccionadosByIdPaquete($scope.serviciosExclusivos[$scope.paquetesExclusivos[i].iId], $scope.paquetesExclusivos[i].iId)[0];
				}
			}
		},function(error){
			console.log(error);
		});

	}else{

		$scope.solicitud.nombreBoton = 'Registrar';

		Solicitudes.ListarSolicitudDetalleParaRegistrar().then(function(data){
			if (data !=null) {

				listarPaquetesYServicios(data[0],data[1]);
				
			}
		},function(error){
			console.log(error);
		});
	}

}])

.directive('solicituddirective',function(){
	return{
		templateUrl: 'template/solicitud.html'
	}
})