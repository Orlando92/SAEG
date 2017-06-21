var app = angular.module('SaegApp.VerSolicitudesRespondidasCtrl', []);

app.controller('VerSolicitudesRespondidasCtrl',['$scope','Solicitudes','Exportar','Util',function($scope, Solicitudes, Exportar, Util){

    $scope.activar('mDashboard','','Solicitudes respondidas','');

    $scope.rutaInformes = "archivos/informes/";
    $scope.rutaAnexos = "archivos/anexos/";

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

    $scope.buscar = function(formulario){

        if (Util.isUndefinedOrNull(formulario))
        {
            formulario = {};
            formulario.sDni = '';
            formulario.sApellidoMaterno = '';
            formulario.sNombres = '';
            formulario.sApellidoPaterno = '';
        }else if(Util.isUndefinedOrNull(formulario.sDni)){
            formulario.sDni = '';
        }

        Solicitudes.ListarSolicitudesRespondidas(formulario).then(function(data){
            console.log(data);
            $scope.datasource.data = data;
        },function(error){

        });
    }

	$scope.datasource = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,  
        showGridFooter:true,
        columnDefs: [

            //{ name: 'Codigo', field : 'iIdSolicitud'},
            { name: 'Fecha Pedido', field : 'dFechaPedido', type: 'date', cellFilter: 'date: "dd/MM/yyyy"'},
            { name: 'Hora Pedido', field : 'dHoraPedido', type:'date'},
            { name: 'Dni', field : 'sDni', type: 'number'},
            { name: 'Apellido Paterno', field : 'sApellidoPaterno'},
            { name: 'Apellido Materno', field : 'sApellidoMaterno' },
            { name: 'Nombres', field : 'sNombres'},
            { name: 'Informe',
              cellTemplate : '<div><a target="_blank" ng-href="' + $scope.rutaInformes + '{{row.entity.Informe}}" ng-class="{\'btn btn-success btn-xs\': row.entity.Informe}"><i ng-class="{\'ion-document-text\': row.entity.Informe}" aria-hidden="true"></i></a></div>',
              cellClass: 'grid-align'},
            { name: 'Anexo',
              cellTemplate : '<a target="_blank" ng-href="'+ $scope.rutaAnexos + '{{row.entity.OtrosDatos}}" ng-class="{\'btn btn-info btn-xs\': row.entity.OtrosDatos }"><i ng-class="{\'ion-document\': row.entity.OtrosDatos}" aria-hidden="true"></i></a>',
              cellClass: 'grid-align'}
            ,
            //{ name: 'Cliente', field : 'sCliente'},
            { name: 'Tipo Antecedente', field : 'sPaqueteInclusivo'},
            { name: 'Domiciliaria',
                cellTemplate: '<div style="text-align: center;"><i style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Domiciliares== 1}" aria-hidden="true"></i></div>'},
            { name: 'Laboral',
            cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Laborales== 1}" aria-hidden="true"></i></div>' },
            { name: 'Financiera',
            cellTemplate: '<div style="text-align: center;"><i  style="margin-top: 8px; color: blue;"  ng-class="{\'fa fa-check\': row.entity.Financieras== 1}" aria-hidden="true"></i></div>' },
            { name: 'Academica',
            cellTemplate: '<div style="text-align: center;"><i   style="margin-top: 8px; color: blue;" ng-class="{\'fa fa-check\': row.entity.Academicas== 1}" aria-hidden="true"></i></div>' },
            { name: 'Poligrafica', field : 'sPaqueteExclusivo'}
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

    ObjetoExportar.NameReporte = "Respondidas";
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



    $scope.buscar($scope.formulario);



}]);
