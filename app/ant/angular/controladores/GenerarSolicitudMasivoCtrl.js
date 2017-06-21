var app = angular.module('facturacionApp.GenerarSolicitudMasivoCtrl', []);

// ================================================
//   Controlador de solicitudes masivas
// ================================================
app.controller('GenerarSolicitudMasivoCtrl', ['$scope','$rootScope','Solicitudes', 'Usuario','Excel', function($scope, $rootScope, Solicitudes, Usuario, Excel){
	
	$scope.activar('mDashboard','','Registro de solicitudes masivas','Importar datos de archivo Excel formato 2003');

	$scope.ruta = '';

	$scope.solicitudes = [];	

	$scope.objs = [];

	$scope.fileSelect = function($fileSelected){        
        $scope.excelFile = $fileSelected;
        $scope.ruta = $scope.excelFile.name;
    };

	$scope.parseExcelToJSON = function () {
	    // Get The File From The Input
	    var oFile = $scope.excelFile;

	    if (angular.isDefined(oFile) == false)
	    {
	    	swal(
				  'Oops...',
				  'Debe seleccionar un archivo!',
				  'error'
				);		
	    	return;
	    }

	    var sFilename = oFile.name;
	    // Create A File Reader HTML5
	    var reader = new FileReader();

	    var res = '';
	    
	    // Ready The Event For When A File Gets Selected
	    reader.onload = function(e) {
	        var data = e.target.result;
	        var cfb = XLS.CFB.read(data, {type: 'binary'});
	        var wb = XLS.parse_xlscfb(cfb);
	        // Loop Over Each Sheet

	        var sheetName = wb.SheetNames[0];
	        //wb.SheetNames.forEach(function(sheetName) {
	            // Obtain The Current Row	           
	            //$scope.array_excel = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]); 
	            
	            //$scope.GrabarRegistros();

	        $scope.objs = Excel.parseExcelToRows(wb.Sheets[sheetName],9);
	        $scope.procesarCadena();

	        //});
	    };	    
	    // Tell JS To Start Reading The File.. You could delay this if desired

	    reader.readAsBinaryString(oFile);

	}

	$scope.procesarCadena = function(){
		
		$scope.solicitudes = [];
		var ii = 1;		

		for (i = 0; i < $scope.objs.length; i++){

			var obj = $scope.objs[i];	

			if (obj.length < 10){ 
				swal(
				  'Oops...',
				  'No se puede procesar el archivo. Su estructura de campos no es correcta!',
				  'error'
				);				
				return; 
			}

			var todosNulos = true;

			for (var iii = 9; iii >= 0; iii--) {
				if (!$scope.esNulo(obj[iii])) {
					todosNulos = false;
					break;
				}
			}

			if (todosNulos == true) {
				continue;
			}

			$scope.solicitud = {};
			$scope.solicitud.persona = {};
			$scope.solicitud.servicios = {};
			var existeServicioSeleccionado = false;
			//validar campos obligatorios
			for (jj = 0; jj < 10; jj++){
				if (jj<=3) {
					if ($scope.esNulo(obj[jj])){ 
						swal(
						  'Oops...',
						  'No se puede procesar el archivo. Un campo obligatorio se encuentra vacío.',
						  'error'
						);					
						return; 
					}
				}				
				/////revisar solo los obligatorios
				if (jj == 3){
					if(!$scope.esNumero(obj[jj])){ 
						swal(
						  'Oops...',
						  'No se puede procesar el archivo. Un campo obligatorio se encuentra vacío.',
						  'error'
						);
						return;
					}
					if (!$scope.comparaLongitudCadena(obj[jj], 8)){ 
						swal(
						  'Oops...',
						  'No se puede procesar el archivo. El DNI debe tener 8 dígitos.',
						  'error'
						);						
						return; 
					}
				}
				if (jj==4) {

					if (!$scope.esNulo(obj[jj])) {

						if (obj[jj]>2 || obj[jj]<1) {
							swal(
							  'Oops...',
							  'Elija correctamente el antecedente.',
							  'error'
							);

							return;
						}



						existeServicioSeleccionado = true;

					}
				}

				if (jj>4 && jj<9) {					

					if (!$scope.esNulo(obj[jj])) {

						if (obj[jj]!='x') {
							swal(
							  'Oops...',
							  'Marque \'x\' en los servicios que quiere solicitar.',
							  'error'
							);
							return;
						}

						existeServicioSeleccionado = true;

					}				

				}

				if (jj==9) {

					if (!$scope.esNulo(obj[jj])) {

						if (obj[jj]>3 || obj[jj]<1) {
							swal(
							  'Oops...',
							  'Elija correctamente la evaluacion poligrafica.',
							  'error'
							);
							return;
						}

						existeServicioSeleccionado = true;

					}

				}
					
			}
			
			if (!existeServicioSeleccionado) {

				swal(
				  'Oops...',
				  'Elija algun servicio.',
				  'error'
				);
				return;
			}


			$scope.solicitud.persona.sApellidoPaterno = obj[0];
			$scope.solicitud.persona.sApellidoMaterno = obj[1];
			$scope.solicitud.persona.sNombres = obj[2];
			$scope.solicitud.persona.sDni = obj[3];
			$scope.solicitud.servicios.Paquete = obj[4];
			$scope.solicitud.servicios.VerificacionLaboral = obj[5];
			$scope.solicitud.servicios.VerificacionFinanciera = obj[6];
			$scope.solicitud.servicios.VerificacionAcademica = obj[7];
			$scope.solicitud.servicios.VerificacionDomiciliaria = obj[8];
			$scope.solicitud.servicios.Poligrafica = obj[9];

			$scope.solicitudes.push($scope.solicitud);			
			ii++;			
		}
		
        
    	jsonSolicitudes = JSON.stringify($scope.solicitudes);
        
        Solicitudes.RegistrarSolicitudMasivo(jsonSolicitudes).then(function(data){
			if (!angular.isUndefined(data)) {

				data = angular.fromJson(data);

				if (data.respuesta == 1) {
					swal(
					  'Bien hecho!',
					  'Se han registrado las solicitudes !.',
					  'success'
					);

					$rootScope.ListarSolicitudesPendientes();
				}else{
					swal(
					  'Oops...',
					  'Hubo un error en la transaccion.',
					  'error'
					);
				}
			}else{
					swal(
				  'Oops...',
				  'Revise su conexion a internet.',
				  'error'
				);
			}
		},function(error){
			console.log(error);
		});
        
		return 1;
	}

	$scope.esNulo = function (value){
		if (value == null){
			return true;
		}		
		return false;
	}

	$scope.esNumero = function (value){
		if (Number.parseInt(value) == NaN){
			return false;
		}
		return true;
	}

	$scope.comparaLongitudCadena = function(value, cantidad){
		if (value.length >= cantidad){
			return true;
		}
		return false;
	}

	$scope.GrabarRegistros = function(){

		/*
		$scope.resultado = '0';
		$scope.parseExcelToJSON();*/
	 	$scope.resultado = $scope.procesarCadena();
      
	 	

        if ($scope.resultado == -1){
        	$scope.resultado = 'No se puede procesar el archivo. Su estructura de campos no es correcta.'
        }
        else if ($scope.resultado == -2){
        	$scope.resultado = 'No se puede procesar el archivo. Un campo obligatorio se encuentra vacío.'
        }
        else if ($scope.resultado == -3){
        	$scope.resultado = 'No se puede procesar el archivo. El DNI debe tener 8 dígitos.'
        }
        else {
        	console.log(JSON.stringify($scope.solicitudes));
            /*
            Solicitudes.RegistrarSolicitudMasivo(JSON.stringify($scope.solicitudes)).then(function(data){
				console.log(data);
			},function(error){
				console.log(error);
			});*/
        }     
	}


}])	
.directive('fileNameChanged',function($parse){

	return {

		restrict: 'A',
		scope: false,

		link: function(scope, element, attrs) {            
            	var fn = $parse(attrs.fileNameChanged);
				element.on('change', function(onChangeEvent) {				
	                scope.$apply(function() {
						fn(scope, {$fileSelected:onChangeEvent.target.files[0]});
					});
					
				});
			
		}
	}

})


;	

