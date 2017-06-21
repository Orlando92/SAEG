app.factory('PDF', ['', function(){
	
	var tablaRespuesta = {
		columns: [], 
		rows: []
	}

	var antecedentes = [];

	var antecedente = {

		nombreAntecedente: '', 
		
		informaciones : []

	};

	var imgUrl = '';

	var logoUrl = '';

	var titulo = '';

	var self = {

		llenarHeaderTablaRespuesta: function(columnas){

			tablaRespuesta.columns = columnas;
		},

		llenarRowsTablaRespuesta: function(rows){

			tablaRespuesta.rows = rows;
		},

		agregarImagen: function(imgUrl){

			imgData = imgUrl;
		},

		agregarAntecedente: function(antecedente){

			antecedentes.push(antecedente);
		}, 

		crearPdf: function(){

			
			
		}









	};

	return self;

}])