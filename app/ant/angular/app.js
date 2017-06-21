var app = angular.module('facturacionApp', ['ngRoute', 'ui.grid','ngTouch','ngAnimate','ui.bootstrap', 'jcs-autoValidate',
		'saegApp.route_config',
		'SaegApp.promesa',
		'facturacionApp.fileupload',
		'saegApp.session_provider',
		'saegApp.acceso_provider',
		'facturacionApp.configuracion',
		'facturacionApp.mensajes',
		'facturacionApp.notificaciones',
		'SaegApp.usuario',
		'SaegApp.paquete',
		'facturacionApp.solicitudes',
		'facturacionApp.servicios',
		'SaegApp.persona',
		'SaegApp.cliente',
		'SaegApp.excel',
		'facturacionApp.dashboardCrtl',
		'facturacionApp.GenerarSolicitudMasivoCtrl',
		'facturacionApp.GenerarSolicitudPersonalCtrl',
		'facturacionApp.InicioCtrl',
		'facturacionApp.ResponderSolicitudesCtrl',
		'SaegApp.Template.SolicitudesPendientesCtrl',
		'SaegApp.Template.SolicitudCtrl',
		'SaegApp.VerSolicitudesRespondidasCtrl',
		'SaegApp.Template.VerSolicitudesClientesCtrl',
		'facturacionApp.ReporteHistoricosCtrl',
		'facturacionApp.DatepickerPopupDemoCtrl',
		'angular-loading-bar',
		'ui.grid.autoFitColumns',

		]);

app.run(['Acceso','Session', 'Servicios','$location','$rootScope','Usuario', function(Acceso,Session,Servicios,$location,$rootScope, Usuario){

	Session.IsLogged().then(function(data){

		if (data == 0) {

			window.location = '../login';
		}

	},function(error){

		console.log(error);
	});



	$rootScope.$on('$locationChangeStart', function(event, next, current) {
	   	var sRuta = $location.path().substring(1);
	   	if (sRuta == 'Inicio' || sRuta == '') {
	   		return;
	   	}
		Acceso.esModuloAutorizado(sRuta).then(function(data){
			if (data == 0) {

				$location.path('/Inicio');
			}

		},function(error){

			console.log(error);
		});
 	});

}]);

angular.module('jcs-autoValidate')
.run([
    'defaultErrorMessageResolver',
    function (defaultErrorMessageResolver) {
        // To change the root resource file path
        defaultErrorMessageResolver.setI18nFileRootPath('angular/lib');
        defaultErrorMessageResolver.setCulture('es-co');
    }
]);

app.controller('mainCtrl', ['$scope','$rootScope','$uibModal', 'Configuracion','Mensajes', 'Notificaciones','Acceso', 'Session', 'Servicios','Usuario','$route','$timeout','$location',
	function($scope, $rootScope, $uibModal, Configuracion, Mensajes, Notificaciones, Acceso, Session, Servicios, Usuario, $route, $timeout, $location){

	Acceso.getModulos().then(function(data){
		$scope.modulos = data;
	},function(error){
		console.error(error);
	});

	$scope.recargarPagina = function(){
		$timeout(function(){
			$route.reload();
		},100)
		
	};

	Usuario.cargarUsuario().then(function(data){

		Usuario.setUsuario(data);

		Usuario.setImgUsuario();

		$scope.usuario = Usuario.getUsuario();

	    $scope.imgUsuario = Usuario.getImgUsuario();

	    $scope.sTipoUsuario = Usuario.getTipoUsuario();

	    if ($scope.sTipoUsuario == 'Cliente') {

	    	$location.path('/GenerarSolicitudPersonal')

	    }


	},function(error){

		console.log(error);
	});

	$scope.abrirCambiarPassword = function(){
		var modalEditarSolicitud =  $uibModal.open({
				animation: true,
				ariaLabelledBy: 'modal-title',
     			ariaDescribedBy: 'modal-body',
     			size: 'md',
      			templateUrl: 'modal/cambiarPassword.html',
      			keyboard: true,
      			controller: function($uibModalInstance, $scope){
      				$scope.cancel = function () {
            			$uibModalInstance.dismiss('cancel');
        			};

        			$scope.cambiarContrasena = function() {
        				if ($scope.cambiarPassword.nueva == $scope.cambiarPassword.repita){
        					Usuario.CambiarPassword($scope.cambiarPassword.antigua, $scope.cambiarPassword.nueva).then(function(data){
        						if (data == 1) {
        							swal('Bien hecho!', 'Se ha cambiado el password correctamente', 'success');
        							$scope.cancel();
        						}else if (data == -2){
        							swal('Oops!', 'El password actual es incorrecto', 'error');
        						}else{
        							swal('Oops!', 'Ha ocurrido un error.', 'error');
        						}
        					},function(error){
        						console.log(error);
        					});
        				}
        			};
      			}
			});
	};


	$scope.config = {};
	$scope.mensajes = Mensajes.mensajes;
	$scope.notificaciones = Notificaciones.notificaciones;

	$scope.titulo    = "";
	$scope.subtitulo = "";

	$scope.usuario = Usuario.getUsuario();




	Configuracion.cargar().then( function(){
		$scope.config = Configuracion.config;
	});


	// ================================================
	//   Funciones Globales del Scope
	// ================================================
	$scope.activar = function( menu, submenu, titulo, subtitulo ){

		$scope.titulo    = titulo;
		$scope.subtitulo = subtitulo;

		$scope.mDashboard = "";
		$scope.mClientes  = "";

		$scope[menu] = 'active';
	}

	$scope.formatoFecha = function(fecha){


	  var mm = fecha.getMonth() + 1; // getMonth() is zero-based
	  var dd = fecha.getDate();

	  return [fecha.getFullYear(),
	          (mm>9 ? '' : '0') + mm,
	          (dd>9 ? '' : '0') + dd
					].join('-');


	}

}]);





// ================================================
//   Filtros
// ================================================
app

.filter( 'quitarletra', function(){

	return function(palabra){
		if( palabra ){
			if( palabra.length > 1)
				return palabra.substr(1);
			else
				return palabra;
		}
	}
})

.filter( 'mensajecorto', function(){

	return function(mensaje){
		if( mensaje ){
			if( mensaje.length > 35)
				return mensaje.substr(0,35) + "...";
			else
				return mensaje;
		}
	}
})

.filter('reverse', function() {
  return function(items) {
    return items.slice().reverse();
  };
})
