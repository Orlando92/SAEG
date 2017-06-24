  <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html ng-app="facturacionApp" ng-controller="mainCtrl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config.aplicativo }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="angular/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="angular/lib/ionicons-2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-    for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-yellow.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="dist/css/animate.css">
    <link rel="stylesheet" href="dist/css/style.css">



    <!-- Importaciones de angular -->
    <script src="angular/lib/angular.min.js"></script>
    <script src="angular/lib/angular-route.min.js"></script>
    <script src="angular/lib/jcs-auto-validate.min.js"></script>

    <!--Angular-Animate-->
    <script src="angular/lib/angular-animate/angular-animate.min.js"></script>

    <!--Angular Touch-->
    <script src="angular/lib/angular-touch/angular-touch.min.js"></script>

    <!--Angular Loading Bar-->
    <link rel="styleSheet" href="angular/lib/angular-loading-bar/loading-bar.css"/>
    <script src="angular/lib/angular-loading-bar/loading-bar.js"></script>


    <!-- ui-Grid -->
    <link rel="styleSheet" href="angular/lib/ui-grid/ui-grid.min.css"/>
    <script src="angular/lib/ui-grid/ui-grid.min.js"></script>
      <!-- ui-grid-auto-fit-columns -->
       <script src="angular/lib/ui-grid/ui-grid-auto-fit-columns/autoFitColumns.min.js"></script>


    <!--ui-bootstrap-->
    <script src="angular/lib/ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js"></script>


    <!--FileSaver-->
    <script src="angular/lib/export/FileSaver.min.js"></script>


    <!-- jsPDF -->
    <script src="angular/lib/jsPDF/jspdf.min.js"></script>
    <script src="angular/lib/jsPDF/jspdf.debug.js"></script>
    <script src="angular/lib/jsPDF/jspdf.autotable.js"></script>

    <!-- SweetAlert -->
    <link rel="stylesheet" href="angular/lib/sweetalert/sweetalert2.min.css">
    <script src="angular/lib/sweetalert/sweetalert2.min.js"></script>


    <!--App -->
    <script src="angular/app.js"></script>

    <!-- Directives -->
    <script type="text/javascript" src="angular/directives/eventos.js"></script>

    <!-- Providers -->
    <script src="angular/providers/acceso_provider.js"></script>
    <script src="angular/providers/session_provider.js"></script>


    <!-- Config Route -->
    <script src="angular/config.js"></script>



    <!-- Controladores -->
    <script src="angular/controladores/dashboardCtrl.js"></script>
    <script src="angular/controladores/GenerarSolicitudPersonalCtrl.js"></script>
    <script src="angular/controladores/GenerarSolicitudMasivoCtrl.js"></script>
    <script src="angular/controladores/ResponderSolicitudesCtrl.js"></script>
    <script src="angular/controladores/InicioCtrl.js"></script>
    <script src="angular/controladores/ServiciosCtrl.js"></script>
    <script src="angular/controladores/VerSolicitudesRespondidasCtrl.js"></script>
    <script src="angular/controladores/ReporteHistoricosCtrl.js"></script>
    <script src="angular/controladores/DatepickerPopupDemoCtrl.js"></script>

        <!-- Templates -->
        <script src="angular/controladores/templates/SolicitudesPendientesCtrl.js"></script>
        <script src="angular/controladores/templates/SolicitudCtrl.js"></script>
        <script src="angular/controladores/templates/VerSolicitudesClientesCtrl.js"></script>
        <script src="angular/controladores/templates/ResponderSolicitudFormalCtrl.js"></script>
        <script src="angular/controladores/templates/ResponderServicioCtrl.js"></script>


    <!-- servicios -->
        
    <script src="angular/servicios/configuracion_service.js"></script>
    <script src="angular/servicios/mensajes_service.js"></script>
    <script src="angular/servicios/notificaciones_service.js"></script>
    <script src="angular/servicios/solicitudes_service.js"></script>
    <script src="angular/servicios/servicios_service.js"></script>
    <script src="angular/servicios/usuario_service.js"></script>
    <script src="angular/servicios/promesa_service.js"></script>
    <script src="angular/servicios/paquete_service.js"></script>
    <script src="angular/servicios/persona_service.js"></script>
    <script src="angular/servicios/cliente_service.js"></script>
    <script src="angular/servicios/excel_service.js"></script>
    <script src="angular/servicios/file_upload.js"></script>
    <script src="angular/servicios/exportar_service.js"></script>
    <script src="angular/servicios/util_service.js"></script>
    <script src="angular/servicios/solicitudDetalle_service.js"></script>
    <script src="angular/servicios/informacion_service.js"></script>
    <script src="angular/servicios/servicioCampo_service.js"></script>



     <!-- Import Excel to JSON -->

    <script src="angular/lib/jszip/jszip.min.js"></script>
    <script src="angular/lib/js/xlsx.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script> -->

    <link rel="stylesheet" type="text/css" href="dist/css/component.css" />
    <!-- <script src="angular/lib/js/custom-file-input.js"></script> -->

  </head>



  <body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="#/Inicio" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="dist/img/cropped-LOGO-SAEG-INVESTIGATION-2017-5.png" style="height: 20px;"/></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="font-family: 'Segoe UI'; font-size: 1.7rem;"><img src="dist/img/cropped-LOGO-SAEG-INVESTIGATION-2017-5.png" style="height: 25px;"/> Saeg System 1.1</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button" ng-click="recargarPagina()">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Messages: style can be found in dropdown.less-->
              <!--<li class="dropdown messages-menu"
                  ng-include="'template/mensajes.html'">
              </li>
              <!-- /.messages-menu -->

              <!-- Notifications Menu -->
              <!--<li class="dropdown notifications-menu"
                  ng-include="'template/notificaciones.html'">
              </li>-->

              <!-- User Account Menu -->
              <li class="dropdown user user-menu"
                  ng-include="'template/usuario.html'">
              </li>

            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar"
          ng-include="'template/menu.html'">
          
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            {{ titulo }}
            <small>{{ subtitulo }}</small>
          </h1>

        </section>

        <!-- Main content -->
        <section class="content" ng-view>

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          {{ config.version }}
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ config.anio }}
            <a href="{{ config.web }}" target="blank">{{config.empresa}}</a>.
        </strong> Derechos reservados.
      </footer>


    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
</html>
