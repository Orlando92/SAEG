var app = angular.module( 'loginApp',['login.loginService']);


app.controller('mainCtrl', ['$scope', 'LoginService','$location', function( $scope, LoginService,$location ){
	
	
	$scope.invalido = false;
	$scope.cargando = false;
	$scope.mensaje  = "";

	$scope.datos = {};

	$scope.ingresar = function( datos ){

		if( datos.usuario.length < 3 ){
			$scope.invalido = true;
			$scope.mensaje  = 'Ingrese su usuario';
			return;

		}else if( datos.password.length < 3 ) {
			$scope.invalido = true;
			$scope.mensaje  = 'Ingrese su contraseña';
			return;
		}

		$scope.invalido = false;
		$scope.cargando = true;

		LoginService.login( datos ).then( function( data ){

			$scope.cargando = false;

			console.log(data);

			if (data == 1) {
				
				 window.location = "../ant/";
			
			}else{

				swal('Oops..!', 'Datos Incorrectos!','error');

			}


		});


	}



}]);






