app.factory('PDF', ['', function(){

	var urlImagenes = 'archivos/imagenes/';
	
	var tablaRespuesta = {
		columns: [], 
		rows: []
	}

	var antecedentes = [];

	var antecedente = {

		nombreAntecedente: '', 
		
		informaciones : []

	};

	var imgUrl = urlImagenes;

	var logoUrl = 'dist/img/logoSaeg.png';

	var confidencial = 'CONFIDENCIAL';

	var fechaPedido = '01-01-2017';

	var titulo = '';

	var self = {

		agregarFechaPedido: function(fechaPedido){
			fechaPedido = fechaPedido;
		}

		llenarHeaderTablaRespuesta: function(columnas){

			tablaRespuesta.columns = columnas;
		},

		llenarRowsTablaRespuesta: function(rows){

			tablaRespuesta.rows = rows;
		},

		agregarImagen: function(nombreImagen){

			imgUrl += nombreImagen+'.jpg';
		},

		agregarAntecedente: function(antecedente){

			antecedentes.push(antecedente);
		}, 

		crearPdf: function(){	

			pdf = new jsPDF();

			/* Agregando el header */
			header = '<header><div style="width: 20%"><img src="'+logoUrl+'"/></div><div style="width: 80%; text-align:right"><div>'+confidencial+'</div><br><div>'+fechaPedido+'</div></div></header>'


			
		}, 











	};

	return self;

}])