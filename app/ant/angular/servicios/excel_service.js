var app = angular.module('SaegApp.excel',[]);

app.service('Excel',[function(){



	var getObjetoDeCelda = function(celda){

		if (angular.isUndefined(celda)) {

			return undefined;

		}

		return String(celda.v);

	}



	var getObjetoRow = function(hoja,row){

		var obj = {};

		var encuentra = false;

		for (var i = 65; i <= 74; i++) {	

			var res = String.fromCharCode(i);		

			var objeto = getObjetoDeCelda(hoja[res+String(row)]);

			if (!angular.isUndefined(objeto)) {

				obj[i-65] =	objeto;

				encuentra = true;

			}else{

				obj[i-65] = null;
			}			

		}

		if (!encuentra) {

			return -1
		}

		return obj;

	}


	this.parseExcelToRows = function(hoja,rowToBegin){

		var objs = [];

		while(true){

			var obj = getObjetoRow(hoja,rowToBegin);

			if (obj == -1) {
				break;
			}

			objs.push(obj);

			rowToBegin++;
		}

		return objs;

	}



}]);