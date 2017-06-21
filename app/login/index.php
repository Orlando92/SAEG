<?php
  session_start();
  session_destroy();
?>

<!DOCTYPE html>
<html ng-app="loginApp" ng-controller="mainCtrl">
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Saeg System | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="angular/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="angular/lib/ionicons-2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE.min.css">


	<script src="angular/lib/angular.min.js"></script>
	<script src="angular/app.js"></script>
	<script src="angular/servicios/login_service.js"></script>


  <!-- SweetAlert -->
  <link rel="stylesheet" href="angular/lib/sweetalert/sweetalert2.min.css">
  <script src="angular/lib/sweetalert/sweetalert2.min.js"></script>




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style media="screen">
       .fondo {
          max-width: 100%;
          height: auto;
          position: absolute;
          left: 0;
          top:0;
          z-index: 0;
          opacity: 0.5;
       }

       .bk {
         background-image: url("img/fondo1.jpg");

       }

       .caja {
         background-color: lightgray;
         z-index: 1;
         opacity: 1;
       }

       /*.titulocaja {
         background-color: white;
         z-index: 1;
         opacity: 1;
         opacity: 0.7;
         border-radius: 10px;
       }*/
    </style>
  </head>

  <body class="hold-transition bk "> <!--login-page

      <img src="fondo1.jpg" class="img-fluid img-thumbnail rounded mx-auto d-block fondo" />-->


    <div class="login-box">
      <div class="login-logo  ">

        <a href=""><b>SAEG</b> System</a>

      </div><!-- /.login-logo -->


      <div class="login-box-body caja">

        <p class="login-box-msg">Ingrese su usuario</p>

        <form name="forma" ng-submit=" ingresar( datos ) ">

          <div class="form-group has-feedback">

            <input type="text"
            	   class="form-control"
            	   placeholder="Usuario"
            	   name="usuario"
            	   required="required"
            	   ng-model="datos.usuario">

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <input type="password"
                   class="form-control"
                   placeholder="Contraseña"
                   name="password"
                   required="required"
            	   ng-model="datos.password">

            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <button type="submit"
              		  class="btn btn-primary btn-block btn-flat"
              		  ng-disabled="forma.$invalid || cargando">Ingresar</button>
            </div><!-- /.col -->
          </div>


		<div class="row" ng-show="invalido">
			<div class="col-md-12">
				<br>
				<div class="alert alert-danger">
					<strong>Verificar!</strong>
					{{ mensaje }}
				</div>
			</div>
		</div>



        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->





  </body>
</html>
