app.factory("Exportar", function () {

    var DefaultTitleFontColor = "#000";
    var DefaultTitleBackgroundColor = "#fff";
    var DefaultBorderTable = "1";
    var DefaultRowFontColor = "#000";
    var DefaultRowBackgroundColor = "#fff";
    var DefaultFontWeight = "bold";
    var DefaultFontSizeEx = "h4";

    function Objeto() {
        var objeto = {};
        objeto.Config = {
            TitleFontColor: "#000",
            TitleBackgroundColor: "#fff",
            BorderTable: "1",
            RowFontColor: "#000",
            RowBackgroundColor: "#fff",
            FontWeight: "bold",
            FontSizeEx: "h4"
        }
        objeto.NameReporte = "Reporte";
        objeto.pathReporte = function () {
            return objeto.NameReporte+".xls";
        },
        objeto.length = 0;
        objeto.cabecera = [];
        objeto.detalle = [];
        return objeto;
    }

    function GenerarTableCabecera(obj) {
        try {

            var row = "";
            var cabeceraRetornar = "";

            if (obj.cabecera === undefined) {
                console.error("Por favor cree la estructura : var obj = new Exportar.Objeto()");
                return;
            }

            if (obj.Config === undefined) {
                obj.Config.TitleBackgroundColor = DefaultTitleBackgroundColor;
                obj.Config.TitleFontColor = DefaultTitleFontColor;
                obj.Config.FontWeight = DefaultFontWeight;
                obj.Config.FontSizeEx = DefaultFontSizeEx;
            }

            for (var atribut in obj.cabecera) {
                row += "<th style='background-color:" + obj.Config.TitleBackgroundColor + ";color:" + obj.Config.TitleFontColor + ";font-weight:" + obj.Config.FontWeight + ";padding:25px 25px'><" + obj.Config.FontSizeEx + ">" +
                        obj.cabecera[atribut] +
                        "</" + obj.Config.FontSizeEx + "></th>";
            }
            cabeceraRetornar = "<tr>" +
                    row
                + "</tr>"
            return cabeceraRetornar;
        }
        catch (error) {
            console.error("Error : " + error + " Por favor cree el elemento con su atributo llamado cabecera (array)");
            return;
        }
    };

    function GenerarTableDetalle(obj) {
        try {
            var conjuntotd = "";
            var detalleRetornar = "";

            if (obj.detalle === undefined) {
                console.error("Por favor cree la estructura : var obj = new Exportar.Objeto()");
                return;
            }

            if (obj.Config === undefined) {
                //obj.Config.BorderTable = DefaultBorderTable;
                obj.Config.RowFontColor = DefaultRowFontColor;
                obj.Config.RowBackgroundColor = DefaultRowBackgroundColor;
            }
            else {
                if (obj.Config.RowFontColor === undefined && obj.Config.RowBackgroundColor === undefined) {
                    obj.Config.RowFontColor = DefaultRowFontColor;
                    obj.Config.RowBackgroundColor = DefaultRowBackgroundColor;
                }
            }

            for (var indice in obj.detalle) {
                for (var indexDet in obj.detalle[indice]) {
                    conjuntotd += "<td style='background-color:" + obj.Config.RowBackgroundColor + ";color:" + obj.Config.RowFontColor + ";padding:25px 25px'>" +
                    obj.detalle[indice][indexDet] +
                    "</td>";
                }
                detalleRetornar += "<tr>" +
                    conjuntotd
                + "</tr>"
                conjuntotd = "";
            }



            return detalleRetornar;
        }
        catch (error) {
            console.error("Error : " + error + " Por favor cree el elemento con su atributo llamado cabecera (array)");
            return;
        }

    }

    function ObtenerTabla(obj) {
        try {
            var table = [];
            if (obj.length == 0) {
                if (obj.Config === undefined) {
                    obj.Config.BorderTable = DefaultBorderTable;
                }
                else {
                    if (obj.Config.BorderTable === undefined) {
                        obj.Config.BorderTable = DefaultBorderTable;
                    }
                }
                var Cabecera = GenerarTableCabecera(obj);
                var Detalle = GenerarTableDetalle(obj);
                var table = ["<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><table border='" + obj.Config.BorderTable + "'>" + Cabecera + Detalle + "</table>"]
                return table;
            }
            else {

                for (value in obj) {
                    var Cabecera = GenerarTableCabecera(obj[value]);
                    var Detalle = GenerarTableDetalle(obj[value]);
                    table.push("<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><table border='" + obj[value].Config.BorderTable + "'>" + Cabecera + Detalle + "</table>");
                }
                return table;
            }


        }
        catch (error) {
            console.log(error)
        }
    }


    function ObtenerCabecera(obj) {
        if (typeof obj !== "object") {
            if (obj.length === 0) {
                console.error("El elemento que estas enviando es un tipo diferente a un array, Necesariamente debes enviar un array");
                return;
            }
        }

        var Cabecera = [];
        for (var property in obj[0]) {
            if (typeof obj[property] !== 'function' && typeof obj[property] !== 'unknown') {
                Cabecera.push(property);
            }
        }
        return Cabecera;
    };

    function ObtenerCabeceraHtml(CabeceraHtml) {
        var cabeceraHtml = "";
        var cabecera = "";
        for (var atribut in CabeceraHtml) {
            cabecera += "<th style='background-color:" + TitleBackgroundColor + ";color:" + TitleFontColor + ";font-weight:bold;padding:25px 25px'><h4>" +
                    CabeceraHtml[atribut] +
                    "</h4></th>";
        }
        cabeceraHtml = "<tr>" +
                cabecera
            + "</tr>"
        return cabeceraHtml;
    };

    function ObtenerDetalle(obj) {
        if (typeof obj !== "object") {
            if (obj.length === 0) {
                console.error("El elemento que estas enviando es un tipo diferente a un array, Necesariamente debes enviar un array");
                return;
            }
        }

        var Detalle = [];
        var Objeto = [];
        var i = 0;
        for (var row in obj) {
            for (var property in obj[row]) {
                if (typeof obj[row][property] !== 'function' && typeof row[property] !== 'unknown') {
                    Objeto.push(obj[row][property]);
                }
            }
            Detalle.push(Objeto);
            Objeto = [];
        }
        return Detalle;
    };

    function ObtenerDetalleHtml(Detalle) {
        var filashtml = "";
        var conjuntotd = "";
        for (var Objeto in Detalle) {
            for (var valores in Detalle[Objeto]) {
                conjuntotd += "<td>" +
                        Detalle[Objeto][valores] + "</td>";
            }
            filashtml += "<tr>" +
                            conjuntotd +
                        "</tr>";
            conjuntotd = "";
        }
        return filashtml;
    };

    function EnviarExcel(objeto,tabla) {

        if (objeto.length == 0) {
            var blob = new Blob(tabla, {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, objeto.pathReporte());
        }
        else{
            var blob = new Blob(tabla, {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, objeto[0].pathReporte());
        }

    }

    return {
        ExcelTable: function (idTable) {
            var blob = new Blob(["<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><table border='1'>" + document.getElementById(idTable).innerHTML], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "Reporte.xls");
        },
        ExcelObjeto: function (Objeto) {
            var tabla = ObtenerTabla(Objeto);
            EnviarExcel(Objeto, tabla);
        },
        Objeto: function () {
            return Objeto();
        }
    }
});