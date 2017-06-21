app.service('Util',['$filter',function($filter){

	this.ObtenerFecha = function (fecha) {
        if (fecha === null || fecha === "") {
            return "";
        }
        else {
            date = new Date(fecha);
            return $filter('date')(fecha, 'yyyy-MM-dd', 'UTC / GMT');
        }

    };

    this.ObtenerHora = function (fecha) {
        if (fecha === null || fecha === "") {
            return "";
        }
        else {
            date = new Date(fecha);
            return $filter('date')(fecha, 'HH:mm', 'UTC / GMT');
        }
    };

    this.ObtenerString = function (valor) {
        if (valor === null || valor === undefined) {
            return "";
        }
        return valor;
    };

    this.isUndefinedOrNull = function(obj) {
        return !angular.isDefined(obj) || obj===null;
    };

     this.isUndefinedOrNullOrEmpty = function(obj) {
        return !angular.isDefined(obj) || obj===null || obj.length == 0 ;
    };

    this.ListarObjetoPorValorDeLlave = function(llave, valor, lista){

      return lista.find(function(objeto){

        return objeto[llave] == valor;

      });
    };

    this.ListarAtributoPorValorDeLlave = function(atributo, llave, valor, lista){

        return lista.find(function(objeto){

            return objeto[llave] == valor;

        })[atributo];

    };

    this.existeAtributoSinLlenar = function(objeto, nroAtributos){

        encuentra = false;

        i = 0;

        angular.forEach(objeto, function(value, key){

            if (value.trim() == '') {

                encuentra = true;
                return;
            }

            i++;

        });

        if (!encuentra && i != nroAtributos) {

            encuentra = true;

        }

        return encuentra;

    };


}]);