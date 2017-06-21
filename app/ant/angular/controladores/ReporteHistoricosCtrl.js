var app = angular.module('facturacionApp.ReporteHistoricosCtrl', []);

// ================================================
//   Controlador de reportes históricos
// ================================================
app.controller('ReporteHistoricosCtrl', ['$scope','$rootScope','Solicitudes', 'FileUpload', '$uibModal','Cliente','$filter','Exportar','Util',
	function($scope, $rootScope, Solicitudes, FileUpload, $uibModal,Cliente, $filter, Exportar, Util){

    $scope.activar('mDashboard','','Solicitudes Historicas','');

		$scope.dtDesde = new Date();
		$scope.dtHasta = new Date();

		$scope.rutaInformes = "archivos/informes/";
  	$scope.rutaAnexos = "archivos/anexos/";

		$scope.formulario = {};
		$scope.formulario.sDni = '';
		$scope.formulario.sNombres = '';
		$scope.formulario.sApellidoPaterno = '';
		$scope.formulario.sApellidoMaterno = '';

		$scope.borrarApellidosYNombres = function(){
        if ($scope.formulario.sDni > 0){
            $scope.formulario.sNombres = '';
            $scope.formulario.sApellidoPaterno = '';
            $scope.formulario.sApellidoMaterno = '';
        }
    };

    $scope.borrarDni = function(){
        if (!Util.isUndefinedOrNullOrEmpty($scope.formulario.sNombres)
            || !Util.isUndefinedOrNullOrEmpty($scope.formulario.sApellidoPaterno)
            || !Util.isUndefinedOrNullOrEmpty($scope.formulario.sApellidoMaterno)) {

            $scope.formulario.sDni = '';
        }
    }


		var solicitudesTotal = [];


    var ListarClientesActivos = function(){
      Cliente.ListarClientesActivos().then(function(data){
        $scope.clientes = data;
      },function(error){
        console.log(data);
      })
    }

    ListarClientesActivos();

		$scope.gridCtrl = {

			uploadFileInformeToUrl : function(data){

				Solicitudes.setFlagEditarSolicitud(true);
				var resultado = false;

				var modalResponderSolicitud = $uibModal.open({
					animation: true,
					ariaLabelledBy: 'modal-title',
						ariaDescribedBy: 'modal-body',
						size: 'lg',
							templateUrl: 'modal/ResponderSolicitud.html',
							keyboard: true,
							controller: function($uibModalInstance, $scope){

								$scope.documento = 'Informe';
								$scope.codigo = data.entity.iIdSolicitud;
								$scope.persona = data.entity.sApellidoPaterno + ' ' + data.entity.sApellidoMaterno + ', ' + data.entity.sNombres;
								$scope.archivo = '';
								$scope.ruta = '';

								$scope.cancel = function () {
										$uibModalInstance.dismiss('cancel');
								};
								$scope.fileSelect = function($fileSelected){
									$scope.archivo = $fileSelected;
									$scope.ruta = $scope.archivo.name;
							};
							$scope.uploadFileInformeToUrl = function(){

				                    if (angular.isDefined($scope.archivo) == false)
				            	    {
				            	    	swal(
				            				  'Oops...',
				            				  'Debe seleccionar un archivo!',
				            				  'error'
				            				);
				            	    	return;
				            	    }

				            	    if ($scope.archivo == '')
				            	    {
				            	    	swal(
				            				  'Oops...',
				            				  'Debe seleccionar un archivo!',
				            				  'error'
				            				);
				            	    	return;
				            	    }

							FileUpload.uploadFileInformeToUrl($scope.archivo, $scope.codigo).then(function(data){
								resultado = true;
								swal(
										'Correcto...',
										'El archivo se cargo correctamente',
										'success'
									);
								modalResponderSolicitud.close();
									return;
							},
							function(data){
								resultado = false;
								swal(
										'Oops...',
										'No se puedo cargar el archivo',
										'error'
									);
									return;

							});


						};
						$scope.cargarArchivo = function(){
							this.uploadFileInformeToUrl();
						}
							}
				});

				modalResponderSolicitud.closed.then(function () {
								Solicitudes.setFlagEditarSolicitud(false);
								if (resultado === true){
									$scope.GenerarReporteHistorico();
								}
						});

			},

			uploadFileAnexoToUrl: function(data){

				Solicitudes.setFlagEditarSolicitud(true);
				var resultado = false;

				var modalResponderSolicitud = $uibModal.open({
					animation: true,
					ariaLabelledBy: 'modal-title',
						ariaDescribedBy: 'modal-body',
						size: 'lg',
							templateUrl: 'modal/ResponderSolicitud.html',
							keyboard: true,
							controller: function($uibModalInstance, $scope){

								$scope.documento= 'Anexo';
								$scope.codigo = data.entity.iIdSolicitud;
								$scope.persona = data.entity.sApellidoPaterno + ' ' + data.entity.sApellidoMaterno + ', ' + data.entity.sNombres;
								$scope.archivo = '';
								$scope.ruta = '';

								$scope.cancel = function () {
										$uibModalInstance.dismiss('cancel');
								};
								$scope.fileSelect = function($fileSelected){
									$scope.archivo = $fileSelected;
									$scope.ruta = $scope.archivo.name;
							};
							$scope.uploadFileAnexoToUrl = function(){

                            if (angular.isDefined($scope.archivo) == false)
                    	    {
                    	    	swal(
                    				  'Oops...',
                    				  'Debe seleccionar un archivo!',
                    				  'error'
                    				);
                    	    	return;
                    	    }

                    	    if ($scope.archivo == '')
                    	    {
                    	    	swal(
                    				  'Oops...',
                    				  'Debe seleccionar un archivo!',
                    				  'error'
                    				);
                    	    	return;
                    	    }

							FileUpload.uploadFileAnexoToUrl($scope.archivo, $scope.codigo).then(function(data){
								resultado = true;
								swal(
										'Correcto...',
										'El archivo se cargo correctamente',
										'success'
									);
								modalResponderSolicitud.close();
									return;
							},
							function(data){
								resultado = false;
								swal(
										'Oops...',
										'No se puede cargar el archivo',
										'error'
									);
									return;

							});


						};
						$scope.cargarArchivo = function(){
							this.uploadFileAnexoToUrl();
						}
							}
				});

				modalResponderSolicitud.closed.then(function () {
								Solicitudes.setFlagEditarSolicitud(false);
								if (resultado === true){
									$scope.GenerarReporteHistorico();
								}
						});
			}

		}


    $scope.datasource = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        showGridFooter:true,
				columnDefs: [

					{ name: 'Fecha Pedido', field : 'dFechaPedido' , type: 'date', cellFilter: 'date: "dd/MM/yyyy"'},
					{ name: 'Hora Pedido', field : 'dHoraPedido' , type: 'date' },
					{ name: 'Dni', field : 'sDni', type:'number' },
					{ name: 'Apellido Paterno', field : 'sApellidoPaterno' },
					{ name: 'Apellido Materno', field : 'sApellidoMaterno'},
					{ name: 'Nombres', field : 'sNombres' },
					{ name: 'Cliente', field : 'sCliente'},
					{ name: 'Tipo Antecedente', field : 'sPaqueteInclusivo' },
					{ name: 'Domiciliaria',
						cellTemplate: '<div style="text-align: center;"><i style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Domiciliares== 1}" aria-hidden="true"></i></div>'},
					{ name: 'Laboral',
					cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Laborales== 1}" aria-hidden="true"></i></div>' },
					{ name: 'Financiera',
					cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Financieras== 1}" aria-hidden="true"></i></div>' },
					{ name: 'Academica',
					cellTemplate: '<div style="text-align: center;"><i   style="margin-top: 8px; color: blue;" ng-class="{\'fa fa-check\': row.entity.Academicas== 1}" aria-hidden="true"></i></div>' },
					{ name: 'Poligrafica', field : 'sPaqueteExclusivo' },

					{ name: 'Informe',
					  cellTemplate : '<div><a target="_blank" ng-href="' + $scope.rutaInformes + '{{row.entity.Informe}}" ng-class="{\'btn btn-success btn-xs\': row.entity.Informe}"><i ng-class="{\'ion-document-text\': row.entity.Informe}" aria-hidden="true"></i></a></div>',
					  cellClass: 'grid-align' },
					{ name: 'Anexo',
					  cellTemplate : '<a target="_blank" ng-href="'+ $scope.rutaAnexos + '{{row.entity.OtrosDatos}}" ng-class="{\'btn btn-info btn-xs\': row.entity.OtrosDatos }"><i ng-class="{\'ion-document\': row.entity.OtrosDatos}" aria-hidden="true"></i></a>',
					  cellClass: 'grid-align' }
					 ,
					{ name: 'Subir informe',
					  cellTemplate : '<button type="button" ng-click="grid.appScope.uploadFileInformeToUrl(row)" class="btn btn-link btn-xs">Subir informe</button>',
					  cellClass: 'grid-align' }
					  ,
					{ name: 'Subir anexo',
					  cellTemplate : '<button type="button" ng-click="grid.appScope.uploadFileAnexoToUrl(row)" class="btn btn-link btn-xs">Subir anexo</button>',
					  cellClass: 'grid-align'}

				],
          appScopeProvider: $scope.gridCtrl
      };


    $scope.exportarExcel = function(){
        var ObjetoExportar = new Exportar.Objeto();
        ObjetoExportar.Config.TitleBackgroundColor = "#808080";
        ObjetoExportar.Config.TitleFontColor = "#fff";
        ObjetoExportar.cabecera = [

            'Codigo Solicitud',
            'Fecha Pedido',
            'Hora Pedido',
            'DNI',
            'Apellido Paterno',
            'Apellido Materno',
            'Nombres',
            'Cliente',
            'PaqueteInclusivo',
            'Domiciliaria',
            'Laboral',
            'Financiera',
            'Academica',
            'Poligrafica',
            'Informe',
            'Anexo',

        ];

    ObjetoExportar.NameReporte = "Historicos";
        var obj = [];
        var datosExportar = [];
        angular.copy($scope.datasource.data, datosExportar);
        //datosExportar = $filter('orderBy')(datosExportar, 'Traslado');
        angular.forEach(datosExportar, function (value, index) {
            obj = [

                value.iIdSolicitud,
                Util.ObtenerFecha(value.dFechaPedido),
                Util.ObtenerHora(value.dHoraPedido),
                value.sDni,
                value.sApellidoPaterno,
                value.sApellidoMaterno,
                value.sNombres,
                value.sCliente,
                value.sPaqueteInclusivo,
                value.Domiciliares == 1 ? 'x':'',
                value.Laborales == 1 ? 'x':'',
                value.Financieras == 1 ? 'x':'',
                value.Academicas == 1 ? 'x':'',
                Util.ObtenerString(value.sPaqueteExclusivo),
                Util.isUndefinedOrNullOrEmpty(value.Informe) ? 'NO': 'SI',
                Util.isUndefinedOrNullOrEmpty(value.OtrosDatos) ? 'NO':'SI',

            ]
            ObjetoExportar.detalle.push(obj);
        });
        Exportar.ExcelObjeto(ObjetoExportar);
    };



	$scope.GenerarReporteHistorico = function(){

		$scope.iIdClienteSeleccionado = $scope.iIdClienteSeleccionado == undefined ? '' : $scope.iIdClienteSeleccionado; 

		Solicitudes.ListarSolicitudesHistoricas($scope.iIdClienteSeleccionado, $scope.formulario.sDni, $scope.formulario.sNombres, $scope.formulario.sApellidoPaterno, $scope.formulario.sApellidoMaterno).then(function(data){
			solicitudesTotal = data;
			console.log(solicitudesTotal);
			$scope.datasource.data = solicitudesTotal;
  		},function(error){
        	console.log(data);
      	});

    };

    $scope.GenerarReporteHistorico();



}])
.directive('reportehistoricosdir',function(){
	return{
		templateUrl: 'template/reporteHistoricos.html'
	}

})
;



/*

editarSolicitud : function(iId){

	Solicitudes.setSolicitudAEditar(iId);

	Solicitudes.setFlagEditarSolicitud(true);



eliminarSolicitud: function(iId){
	swal({
		title: '¿Está seguro?',
		text: "Se eliminará la solicitud con número "+iId,
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar',
		onClose: function(){
			$scope.GenerarReporteHistorico();
		}
	}).then(function () {
		Solicitudes.EliminarSolicitud(iId).then(function(data){

			if (!angular.isUndefined(data)) {
				if (data == 1){
					$rootScope.ListarSolicitudesPendientes();
					swal(
							'Conseguido!',
							'Se ha eliminado la solicitud',
							'success'
						)
				}else{
					swal(
							'Error!',
							'Ha ocurrido un error',
							'error'
						)
				}
			}else{
				swal('Error de red !', 'Parece que no tiene internet', 'error');
			}

		},function(error){
			console.log(error);

		});
	})
},


var modalEditarSolicitud =  $uibModal.open({
	animation: true,
	ariaLabelledBy: 'modal-title',
		ariaDescribedBy: 'modal-body',
		size: 'lg',
			templateUrl: 'modal/EditarSolicitud.html',
			keyboard: true,
			controller: function($uibModalInstance, $scope){
				$scope.cancel = function () {
						$uibModalInstance.dismiss('cancel');
				};
			}
});

modalEditarSolicitud.closed.then(function () {
	$scope.GenerarReporteHistorico();
				Solicitudes.setFlagEditarSolicitud(false);
		});


},






$scope.fileSelect = function($fileSelected){
			$scope.archivo = $fileSelected;
			$scope.ruta = $scope.archivo.name;
	};


$scope.uploadFileInformeToUrl = function(){
		 var file = $scope.myFile;

		 var uploadUrl = "/archivos/informes";
		 FileUpload.uploadFileInformeToUrl(file, $scope.codigo);
	};

	$scope.uploadFileAnexoToUrl = function(){
		 var file = $scope.myFile;

		 var uploadUrl = "/archivos/informes";
		 FileUpload.uploadFileAnexoToUrl(file, $scope.codigo);
	};


$scope.SetDesde = function(fecha_seleccionada) {
	var fecha_seleccionada = new Date(fecha_seleccionada);
	$scope.dtDesde = fecha_seleccionada;
};

$scope.SetHasta = function(fecha_seleccionada) {
	var fecha_seleccionada = new Date(fecha_seleccionada);
	$scope.dtHasta = fecha_seleccionada;
};


{ name: 'Editar',
	cellTemplate : '<button type="button" ng-click="grid.appScope.editarSolicitud(row.entity.iIdSolicitud)" class="btn btn-warning btn-xs"><i class="ion-edit"></i></button>',
	cellClass: 'grid-align'},
{ name: 'Eliminar',
	cellTemplate : '<button type="button" ng-click="grid.appScope.eliminarSolicitud(row.entity.iIdSolicitud)" class="btn btn-danger btn-xs"><i class="ion-trash-a"></i></button>',
	cellClass: 'grid-align'},

//{ name: 'Codigo', field : 'iIdSolicitud' },
*/
