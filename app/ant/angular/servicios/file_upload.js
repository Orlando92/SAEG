var app = angular.module('facturacionApp.fileupload',[]);


app.factory('FileUpload', ['Promesa', function (Promesa) {


    var url = '../php/ws/FileWS.php';
  
    var self = {

      uploadFileInformeToUrl : function(file, iId){

        var fd = new FormData();

        fd.append('codigo', iId);
        fd.append('funcion', 'uploadFileInformeToUrl');
        fd.append('file', file);

        return Promesa.getPromiseFile(fd, url);

      },
      uploadFileAnexoToUrl : function(file, iId){

        var fd = new FormData();

        fd.append('codigo', iId);
        fd.append('funcion', 'uploadFileAnexoToUrl');
        fd.append('file', file);

         return Promesa.getPromiseFile(fd, url);

      }
    }

    return self;

 }]);
