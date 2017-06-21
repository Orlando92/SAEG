var app = angular.module('SaegApp.Template.SolicitudesPendientesCtrl', []);

app.controller('SolicitudesPendientesCtrl', ['$scope','$rootScope','Solicitudes','$uibModal','Exportar','Util', function($scope, $rootScope, Solicitudes,$uibModal, Exportar, Util){

	

	$scope.cancel = function(){
		alert('hola');
	};

	$scope.gridCtrl = {
		editarSolicitud : function(iId){	

			Solicitudes.setSolicitudAEditar(iId);		

			Solicitudes.setFlagEditarSolicitud(true);

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
				$rootScope.ListarSolicitudesPendientes();
            	Solicitudes.setFlagEditarSolicitud(false);
        	});

			
		},

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
			  	$rootScope.ListarSolicitudesPendientes();
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

		solicitudPasada: function(dFecha){
			var fechaSolicitud = new date(dFecha);
			var fechaActual = new date();
			var horas = 1000*60*60;
			if (fechaActual.getTime() - fechaSolicitud.getTime() >= horas) {

			}
		}

	}



	$scope.datasource = {        
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        showGridFooter:true,
        columnDefs: [
        	{ name: 'Editar', 
        	  cellTemplate : '<button type="button" ng-disabled = "row.entity.iSolicitudPasada == 1" ng-click="grid.appScope.editarSolicitud(row.entity.iIdSolicitud)" class="btn btn-warning btn-xs"><i class="ion-edit"></i></button>',
        	  cellClass: 'grid-align' },
			{ name: 'Eliminar', 
        	  cellTemplate : '<button type="button" ng-disabled = "row.entity.iSolicitudPasada == 1" ng-click="grid.appScope.eliminarSolicitud(row.entity.iIdSolicitud)" class="btn btn-danger btn-xs"><i class="ion-trash-a"></i></button>',
        	  cellClass: 'grid-align'},
			//{ name: 'Codigo', field : 'iIdSolicitud', width : 100 },
			{ name: 'Fecha Pedido', field : 'dFechaPedido' , type: 'date',  cellFilter: 'date: "dd/MM/yyyy"'},
			{ name: 'Hora Pedido', field : 'dHoraPedido' , type: 'date' },
			{ name: 'Dni', field : 'sDni', type:'number' },
			{ name: 'Apellido Paterno', field : 'sApellidoPaterno'},
			{ name: 'Apellido Materno', field : 'sApellidoMaterno' },
			{ name: 'Nombres', field : 'sNombres' },
			//{ name: 'Cliente', field : 'sCliente', width: 100 },
			{ name: 'Tipo Antecedente', field : 'sPaqueteInclusivo'},
			{ name: 'Domiciliaria',width: 110, 
				cellTemplate: '<div style="text-align: center;"><i style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Domiciliares== 1}" aria-hidden="true"></i></div>'},
			{ name: 'Laboral', 
			cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Laborales== 1}" aria-hidden="true"></i></div>' },
			{ name: 'Financiera', 
			cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Financieras== 1}" aria-hidden="true"></i></div>' },
			{ name: 'Academica', 
			cellTemplate: '<div style="text-align: center;"><i   style="margin-top: 8px; color: blue;" ng-class="{\'fa fa-check\': row.entity.Academicas== 1}" aria-hidden="true"></i></div>' },
			{ name: 'Poligrafica', field : 'sPaqueteExclusivo' }
          
        ],

        onRegisterApi: function(gridApi){ $scope.gridApi = gridApi;},

        appScopeProvider: $scope.gridCtrl 
    };

    $rootScope.ListarSolicitudesPendientes = function(){

	    Solicitudes.ListarSolicitudesPendientes().then(function(data){
			$scope.datasource.data = data;
		},function(error){
			console.log(error);
		});

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
        	'Poligrafica'

        ];

        ObjetoExportar.NameReporte = "Pendientes"; 
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
				Util.ObtenerString(value.sPaqueteExclusivo)		

			]
            ObjetoExportar.detalle.push(obj);
        });
        Exportar.ExcelObjeto(ObjetoExportar);
    };

    $scope.manejarRedimensionGrilla = function(){
    	//$('#grid').load(document.URL +  ' #grid');
    	//$scope.gridApi.core.refresh();
    };

    $rootScope.ListarSolicitudesPendientes();

 

}])
.directive('solicitudespendientesdir',function(){
	return{
		templateUrl: 'template/solicitudesPendientes.html'
	}

});	