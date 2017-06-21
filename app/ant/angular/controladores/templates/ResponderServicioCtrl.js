app.controller('ResponderServicioCtrl', ['$scope','Informacion','Util','ServicioCampo','datosServicio', function($scope,Informacion, Util,ServicioCampo,datosServicio){

	/* Configuracion  */

	$scope.configuracion = {};


	/* Objetos del DOM */

	$scope.informacionesAnteriores = [];

	$scope.formulario = {};

	$scope.formulario.tieneAntecedentes = false;	

	$scope.formulario.antecedentesIngresados = [];

	/* Variables locales */


	/*Funciones del Scope*/

	$scope.eventos = {};

	$scope.eventos.agregarInformacion = function(servicio, dFecha){

		if (Util.existeAtributoSinLlenar(servicio, $scope.servicioCampos.length) || Util.isUndefinedOrNullOrEmpty(dFecha)) {

			swal(
			  'Oops...',
			  'Existen atributos sin llenar',
			  'warning'
			);

			return;
		}

		var datos =	 {};

		var camposServicio = [];

		angular.forEach(servicio, function(value, key){

			var campoServicio = {
				iId: key, 
				sDescripcion: Util.ListarAtributoPorValorDeLlave('sDescripcion', 'iId', key, $scope.servicioCampos), 
				sValor: value.trim()
			}; 

			camposServicio.push(campoServicio);
		});

		datos.camposServicio = camposServicio; 
		datos.dFecha = dFecha;

		$scope.formulario.antecedentesIngresados.push(datos);

		document.getElementById('formCamposServicio').reset();
	};

	$scope.eventos.manejarEventoGuardarRespuesta = function(antecedentesIngresados){

		Informacion.IngresarInformacionServicioPersona(datosServicio.iIdSolicitudDetalle, datosServicio.iIdPersona, $scope.formulario.tieneAntecedentes, datosServicio.iIdServicio, antecedentesIngresados).then(function(data){

			if (!Util.isUndefinedOrNullOrEmpty(data)) {

				if (data == 1) {

					swal(
					  'Bien hecho...!',
					  'Se ha registrado la información correctamente',
					  'success'
					);

				}else{

					swal(
					  'Oops...',
					  'Ha ocurrido un error',
					  'alert'
					);
				}

			}else{

				swal(
				  'Oops...',
				  'Ha ocurrido un error',
				  'alert'
				);
			}

		}, function(error){

			swal(
			  'Oops...',
			  'Ha ocurrido un error',
			  'alert'
			);
		});
	};



	/*Funciones locales*/

	var ListarInformacionServicioPersona = function(iIdPersona, iIdServicio){

		Informacion.ListarInformacionServicioPersona(iIdPersona, iIdServicio).then(function(data){

			if(!Util.isUndefinedOrNull(data)){

				if(data.length > 0){

					$scope.informacionesAnteriores = Informacion.ListarCamposInformaciones(data);

					$scope.formulario.tieneAntecedentes = true;
				}

			}else{

				swal(
				  'Oops...',
				  'Ha ocurrido un error',
				  'alert'
				);
			}

		}, function(error){

			console.log(error);

			swal(
				  'Oops...',
				  'Ha ocurrido un error en la petición HTTP. Comuníquese con el administrador del sistema.',
				  'alert'
			);
		})

	};

	var ListarServicioCampos = function(iIdServicio){

		ServicioCampo.ListarServicioCampos(iIdServicio).then(function(data){

		if(!Util.isUndefinedOrNull(data)){

				if(data.length > 0){

					$scope.servicioCampos = data;

				}else{

					swal(
					  'Oops...',
					  'El servicio no tiene campos',
					  'alert'
					);

				}

			}else{

				swal(
				  'Oops...',
				  'Ha ocurrido un error',
				  'alert'
				);
			}

		}, function(error){

			console.log(error);

			swal(
				  'Oops...',
				  'Ha ocurrido un error en la petición HTTP. Comuníquese con el administrador del sistema.',
				  'alert'
			);
		});


	}; 



	ListarInformacionServicioPersona(datosServicio.iIdPersona, datosServicio.iIdServicio); 

	ListarServicioCampos(datosServicio.iIdServicio);
	
}]);