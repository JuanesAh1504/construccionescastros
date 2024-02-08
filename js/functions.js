document.write('<script src="js/jquery-3.7.1.min.js"></script>');

function agregarFila() {
    var rowCount = $("#dynamic-table tbody tr").length - 1;
    var newRow = $("<tr>");

    newRow.append($("<td><input type='text' class='inputPersonalizado campoFormulario' id='materiales_" + rowCount + "'></td>"));
    newRow.append($("<td><input type='text' class='inputPersonalizado campoFormulario' id='metrosUnidades_" + rowCount + "'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='precioUnitario_" + rowCount + "' onchange='formatoPesoColombiano(this);calcularFormula(\"cantidad_" + rowCount + "\", \"precioUnitario_" + rowCount + "\", \"precioTotal_" + rowCount + "\");calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales();calcularCamposAdicionales(2)'></td>"));
    newRow.append($("<td><input style='width:70px' type='text' class='inputPersonalizado campoFormulario campoNumero' id='cantidad_" + rowCount + "' value='1' onchange='calcularFormula(\"precioUnitario_" + rowCount + "\", \"cantidad_" + rowCount + "\", \"precioTotal_" + rowCount + "\");calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales();calcularCamposAdicionales(2)'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='precioTotal_" + rowCount + "' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='iva_" + rowCount + "' onchange='calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales();calcularCamposAdicionales(2)'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalIva_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='retefuente_" + rowCount + "' onchange='calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales();calcularCamposAdicionales(2)'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalRetefuente_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalPorTodo_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));    
    newRow.append($("<td><input style='width:110px' type='text' id='totalIncluidoOtrosPrecios_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='precioUnitarioFinal_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));

    newRow.append("<td><button type='button' class='btn btn-danger btn-sm delete-row-button' onclick='eliminarFila(this)'>-</button></td>");
    $('#rowCount').val(rowCount + 1);
    // Agregar la nueva fila a la tabla
    $("#dynamic-table tbody").append(newRow);
    
}


function eliminarFila(){
    var rowCount = parseInt($("#rowCount").val());
    $("#dynamic-table").on("click", ".delete-row-button", function() {
        $(this).closest("tr").remove();
    });
    rowCount--;
    $("#rowCount").val(rowCount);
    setTimeout(() => {
        sumarPrecioTotal();
    }, 50);
}

function agregarCeldaCotizacion(){
    var firstRow = $("#dynamic-table tbody tr:first").clone();
    var rowCount = 
    $(firstRow).find('input').each(function () {
        var currentId = $(this).attr('id');
        if (currentId) {
            var newId = currentId + "_" + rowCount;
            $(this).attr('id', newId);
        }
        if ($(this).is('input') && $(this).attr('onchange')) {
            var originalOnchange = $(this).attr('onchange');
            $(this).attr('onchange', originalOnchange + '_' + rowCount);
        }
        if ($(this).is('input')) {
            // Limpiar el valor de los input de texto
            $(this).val('');
        }
    });
    $("#dynamic-table tbody").append(firstRow);
}

function sumarPrecioTotal() {
    var precioTotal = 0;
    var totalIva = 0;
    var totalRetefuente = 0;
    var totalPorTodo = 0;
    var manoObra = 0;
    var elementosProteccion = 0;
    var totalValoresIncluidos = 0;
    var precioUnitarioFinal = 0;
    precioTotal += eliminarPuntosYConvertirAFloat($("#precioTotal").val()) || 0; // Tratar el caso especial
    totalIva += eliminarPuntosYConvertirAFloat($("#totalIva").val()) || 0; // Tratar el caso especial
    totalRetefuente += eliminarPuntosYConvertirAFloat($("#totalRetefuente").val()) || 0; // Tratar el caso especial
    totalPorTodo += eliminarPuntosYConvertirAFloat($("#totalPorTodo").val()) || 0; // Tratar el caso especial
    manoObra += eliminarPuntosYConvertirAFloat($("#manoObra").val()) || 0; // Tratar el caso especial
    elementosProteccion += eliminarPuntosYConvertirAFloat($("#elementosProteccion").val()) || 0; // Tratar el caso especial
    totalValoresIncluidos += eliminarPuntosYConvertirAFloat($("#totalIncluidoOtrosPrecios").val()) || 0; // Tratar el caso especial
    precioUnitarioFinal += eliminarPuntosYConvertirAFloat($("#precioUnitarioFinal").val()) || 0; // Tratar el caso especial

    // Sumar los valores de los campos con el formato adecuado
    $("input[id^='precioTotal_']").each(function() {
        precioTotal += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    $("input[id^='totalIva_']").each(function() {
        totalIva += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    $("input[id^='totalRetefuente_']").each(function() {
        totalRetefuente += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    $("input[id^='totalPorTodo_']").each(function() {
        totalPorTodo += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    $("input[id^='totalIncluidoOtrosPrecios_']").each(function() {
        totalValoresIncluidos += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    $("input[id^='precioUnitarioFinal_']").each(function() {
        precioUnitarioFinal += eliminarPuntosYConvertirAFloat($(this).val()) || 0;
    });
    
    $("#totalNeto").text(precioTotal.toLocaleString('es-CO'));
    $("#totalNetoInput").val(precioTotal.toLocaleString('es-CO'));

    $("#totalIVA").text(totalIva.toLocaleString('es-CO'));
    $("#totalIVAInput").val(totalIva.toLocaleString('es-CO'));

    $("#totalRetefuenteTabla").text(totalRetefuente.toLocaleString('es-CO'));
    $("#totalRetefuenteTablaInput").val(totalRetefuente.toLocaleString('es-CO'));

    $("#totalPorTodoTabla").text(totalPorTodo.toLocaleString('es-CO'));
    $("#totalPorTodoTablaInput").val(totalPorTodo.toLocaleString('es-CO'));

    $("#precioUnitarioFinalTabla").text(precioUnitarioFinal.toLocaleString('es-CO'));
    $("#precioUnitarioFinalInput").val(precioUnitarioFinal  .toLocaleString('es-CO'));

    $("#totalValoresIncluidos").text(totalValoresIncluidos.toLocaleString('es-CO'));
    $("#totalValoresIncluidosInput").val(totalValoresIncluidos.toLocaleString('es-CO'));
    $("#valorTotalCotizacion").val(totalValoresIncluidos.toLocaleString('es-CO'));
}

function calcularDiferenciaEnDias() {
    // Obtén los valores de las fechas desde los campos de entrada
    var fechaInicio = document.getElementById("fechaCotizacion").value;
    var fechaFin = document.getElementById("fechaCotizacionFin").value;

    // Convierte esas cadenas de fecha en objetos de fecha
    var fechaInicioObj = new Date(fechaInicio);
    var fechaFinObj = new Date(fechaFin);

    // Calcula la diferencia en milisegundos entre las dos fechas
    var diferenciaEnMilisegundos = fechaFinObj - fechaInicioObj;

    // Convierte la diferencia en días
    var diferenciaEnDias = diferenciaEnMilisegundos / (1000 * 60 * 60 * 24);

    // Imprime la diferencia en días
    $('#dias').val(diferenciaEnDias);
}



function eliminarFilaEdicion(button){
    var rowCount = parseInt($("#rowCount").val());
    var row = $(button).closest("tr");
    var id = $(button).data("id"); // Obtén el ID del registro a eliminar desde el botón
    if (confirm("¿Estás seguro de que deseas eliminar esta fila? Los cambios NO se podrán deshacer.")) {
        // Realiza una solicitud al servidor para eliminar el registro en la base de datos
        let data = {};
        data["accion"] = "D-filaCotizacion",
        data["id"] = id;
        $.ajax({
            type: "POST",
            url: "action.php", // Nombre del archivo PHP para eliminar registros
            data: data,
            success: function (data) {
                try {
                    const jsonResponse = JSON.parse(data); // Intenta analizar la respuesta como JSON
                    if (jsonResponse.success === true) {
                        mostrarAlertas([jsonResponse.message], "success");
                        row.remove();
                        rowCount--;
                        $("#rowCount").val(rowCount);
                    } else if (jsonResponse.danger === true) {
                        mostrarAlertas([jsonResponse.message], "danger");
                    } 
                } catch (e) {
    
                }
            },
            error: function (error) {
                mostrarAlertas(["Hubo un error al eliminar la fila"], "danger");
            }
        });
    }
}

function generarNumeroAleatorio() {
    const numeroAleatorio = Math.floor(10000 + Math.random() * 90000);
    const inputNumero = document.getElementById("documentoId");
    if($(inputNumero).val() == ''){
        inputNumero.value = numeroAleatorio;
    }
}

function formatoPesoColombiano(campo){
    let valor = $(campo).val();
    valor = valor.replace(/,/g, '');
    valor = valor.replace(/\./g, ''); // Elimina puntos
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $(campo).val(valor);
}

function formatoPesoColombianoReturn(valor) {
    if (valor !== '') { // Verificar si el valor no está vacío
        if (!isNaN(valor)) { // Verificar si el valor es un número
            valor = valor.toString(); // Convertir a cadena de texto si no lo es
            valor = valor.replace(/,/g, ''); // Elimina comas (,)
            valor = valor.replace(/\./g, ''); // Elimina puntos (.)
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Aplicar formato de pesos colombianos
        }
        // Si el valor no es un número o está vacío, se mantendrá sin cambios.
    }
    return valor;
}

function eliminarPuntosYConvertirAFloat(valor) {
    if (valor === undefined || valor === null || valor === "") {
        return 0; // o cualquier otro valor predeterminado que desees devolver
    }
    if (typeof valor === 'number') {
        // Si ya es un número, quitar puntos y redondear
        return Math.round(valor);
    } else if (typeof valor === 'string') {
        // Si es una cadena, convertir y quitar puntos
        return parseFloat(valor.replace(/\./g, '').replace(',', '.'));
    } else {
        return NaN; // o cualquier otro valor predeterminado que desees devolver
    }
}


function calcularFormula(campoACalcularId, campoActualId, campoDestinoId){
    let campoACalcularValor = eliminarPuntosYConvertirAFloat($('#' + campoACalcularId).val()) || 0;
    let campoActualValor = eliminarPuntosYConvertirAFloat($('#' + campoActualId).val()) || 0;
    const valorTotal = (campoACalcularValor * campoActualValor);
    $("#" + campoDestinoId).val(valorTotal);
    formatoPesoColombiano($("#" + campoDestinoId));
}

function calcularIva(campoACalcularId, campoActualId, campoDestinoId){
    let campoACalcularValor = eliminarPuntosYConvertirAFloat($('#' + campoACalcularId).val()) || 0;
    let campoActualValor = eliminarPuntosYConvertirAFloat($('#' + campoActualId).val()) || 0;
    let totalIva = parseInt(campoACalcularValor * (campoActualValor / 100));
    $("#" + campoDestinoId).val(totalIva) ;
    formatoPesoColombiano($("#" + campoDestinoId));
}

function calcularRetefuente(campoACalcularId, campoActualId, campoDestinoId){
    let campoACalcularValor = eliminarPuntosYConvertirAFloat($('#' + campoACalcularId).val()) || 0;
    let campoActualValor = parseFloat($('#' + campoActualId).val()) || 0;
    let totalRetefuente = parseInt(campoACalcularValor * (campoActualValor / 100));
    if(totalRetefuente !== 0){
        $("#" + campoDestinoId).val(totalRetefuente);
        formatoPesoColombiano($("#" + campoDestinoId));
    }
}

function valorTotal(camposACalcular, campoDestinoId) {
    var valorNeto = $(camposACalcular[0]).val() || 0; // Si el valor está vacío, se establece como 0
    if(valorNeto !== 0){
        valorNeto = eliminarPuntosYConvertirAFloat(valorNeto);
    }
    var valorIva = $(camposACalcular[1]).val() || 0;
    if(valorIva !== 0){
        valorIva = eliminarPuntosYConvertirAFloat(valorIva);
    }
    var valorRetefuente = $(camposACalcular[2]).val() || 0;
    if(valorRetefuente !== 0){
        valorRetefuente = eliminarPuntosYConvertirAFloat(valorRetefuente);
    }
    var total = valorNeto + valorIva + valorRetefuente;
    $("#" + campoDestinoId).val(total);
    formatoPesoColombiano($("#" + campoDestinoId));
}

function calcularConPorcentaje(valor, total) {
    if (!valor || valor.trim() === "") {
        return 0;
    }

    if (valor.includes('%')) {
        valor = parseFloat(valor.replace(/\./g, "").replace(",", "."));
        return parseInt(total * (valor / 100));
    } else {
        return eliminarPuntosYConvertirAFloat(valor);
    }
}
/*
Tipo 1 = gastos totales incluído otros valores
Tipo 2 = precio unitario final
*/
function calcularCamposAdicionales(tipo) {
    var valorManoObra = $("#manoObra").val();
    var valorPorcentajeAdmin = $("#porcentajeAdmin").val();
    var valorPorcentajeUtilidad = $("#porcentajeUtilidad").val();
    var valorAlquilerEquipos = $("#alquilerEquipos").val();
    var valorTransporte = $("#transporte").val();
    var valorElementosProteccion = $("#elementosProteccion").val();
    var valorDotacion = $("#Dotacion").val();

    var filas = $("#dynamic-table tbody tr").not(".addNuevaFila");

    for (var index = 0; index < filas.length; index++) {
        var campoTotalId = (index === 0) ? "#totalPorTodo" : "#totalPorTodo_" + index;
        var totalTabla = eliminarPuntosYConvertirAFloat($(campoTotalId).val()) || 0;

        let SvalorManoObra = calcularConPorcentaje(valorManoObra, totalTabla);
        let SvalorPorcentajeAdmin = calcularConPorcentaje(valorPorcentajeAdmin, totalTabla);
        let SvalorPorcentajeUtilidad = calcularConPorcentaje(valorPorcentajeUtilidad, totalTabla);
        let SvalorAlquilerEquipos = calcularConPorcentaje(valorAlquilerEquipos, totalTabla);
        let SvalorTransporte = calcularConPorcentaje(valorTransporte, totalTabla);
        let SvalorElementosProteccion = calcularConPorcentaje(valorElementosProteccion, totalTabla);
        let SvalorDotacion = calcularConPorcentaje(valorDotacion, totalTabla);

        totalTabla += SvalorManoObra + SvalorPorcentajeAdmin + SvalorPorcentajeUtilidad + SvalorAlquilerEquipos + SvalorTransporte + SvalorElementosProteccion + SvalorDotacion;

        if (index === 0) {
            if(tipo === 2){
                let campoCantidad = $(filas[index]).find('#cantidad').val();
                totalTabla = Math.round(totalTabla / campoCantidad);
                $('#precioUnitarioFinal').val(totalTabla);
                formatoPesoColombiano($("#precioUnitarioFinal"));
                continue;
            }
            $("#totalIncluidoOtrosPrecios").val(totalTabla);
            formatoPesoColombiano($("#totalIncluidoOtrosPrecios"));
        } else {
            if(tipo === 2){
                let campoCantidad = $(filas[index]).find('#cantidad_'+index).val();
                totalTabla = Math.round(totalTabla / campoCantidad);
                $('#precioUnitarioFinal_'+index).val(totalTabla);
                formatoPesoColombiano($("#precioUnitarioFinal_"+index));
                continue;
            }
            $("#totalIncluidoOtrosPrecios_" + index).val(totalTabla);
            formatoPesoColombiano($("#totalIncluidoOtrosPrecios_" + index));
        }
    }

    sumarPrecioTotal();
}

function peticionListado(accion, datos){
    let data = {};
    data["accion"] = accion;
    $.ajax({
        url: 'action.php',
        method: 'POST',
        data: data, // Puedes enviar opciones o datos específicos
        success: function (response) {
            try {
                const jsonResponse = JSON.parse(response); // Si la respuesta es JSON
                if (jsonResponse.success === true) {
                    mostrarAlertas([jsonResponse.message], "success");
                } else if (jsonResponse.danger === true) {
                    mostrarAlertas([jsonResponse.message], "danger");
                }
            } catch (e) {
                // Si la respuesta no es JSON, asumimos que es una tabla HTML
                // Mostramos la respuesta en algún elemento HTML, por ejemplo, un div con id 'resultados'
                $('#tablaListado').html(response);
            }
        },
    });
}

function descargarPDF(idDocumento) {
    // Realiza una solicitud AJAX al servidor para llamar a la función PHP
    let data = {};
    data['documento'] = idDocumento;
    data['accion'] = "descargarPDF";
    $.ajax({
        url: 'functions.php', // Reemplaza con la ruta correcta a tu archivo PHP
        type: 'POST',
        data: data,
        success: function(response) {
            // Abre el PDF en una nueva ventana o pestaña del navegador
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            window.open(url, '_blank');
        },
        error: function() {
            // Maneja errores de la solicitud AJAX
        }
    });
}

function eliminarRegistro(documento, tabla){
    let data = {};
    data["documento"] = documento,
    data["tabla"] = tabla,
    data["accion"] = 'D-doc';
    if (confirm("¿Estás seguro de que deseas eliminar esta fila? Los cambios NO se podrán deshacer.")) {
        $.ajax({
            type: "POST",
            url: "action.php", // Nombre del archivo PHP para eliminar registros
            data: data,
            success: function (data) {
                try {
                    const jsonResponse = JSON.parse(data); // Intenta analizar la respuesta como JSON
                    if (jsonResponse.success === true) {
                        mostrarAlertas([jsonResponse.message], "success");
                        $('tr#'+documento).remove();
                    } else if (jsonResponse.danger === true) {
                        mostrarAlertas([jsonResponse.message], "danger");
                    } 
                } catch (e) {

                }
            },
            error: function (error) {
                mostrarAlertas(["Hubo un error al eliminar la fila"], "danger");
            }
        });
    }
}

function inicializarPaginaContabilidad() {
    setTimeout(function() {
        cargarCotizaciones();
    }, 500);
}

function cargarInfoCotizaciones(){
    let campo = $('#cotizacionSelect');
    var selectedCotizacion = $(campo).val();
    if(selectedCotizacion !== "") {
        detallesContabilidad(selectedCotizacion);
    } else {
        $("#infoCotizacion").empty();
    }
}

function cargarCotizaciones() {
    // Realizar la solicitud para obtener las opciones del selects
    sendXML(2, 'S-Contrato', '', cargarCotizacionesAnswer);
    
}

function cargarCotizacionesAnswer(xml){
    let selectContrato = $('#cotizacionSelect');
    let valueOptions = $('documentoId',xml);
    let options = $('alcanceObra',xml);
    let htmlOptions = '<option value=""></option>';
    for(let i = 0; i < options.length; i++){
        let valueOption = $(valueOptions[i]).text();
        htmlOptions += '<option value="'+valueOption+'">'+$(options[i]).text()+'</option>';
    }
    $(selectContrato).html(htmlOptions);
}
function obtenerInfoCotizacion(cotizacionID) {
        let data = {
            cotizacionID: cotizacionID,
            accion: "obtenerInfoCotizacionContabilidad"
        };
    
        $.ajax({
            url: "search.php", // Archivo PHP que maneja la consulta a la base de datos
            method: "POST",
            data: data,
            dataType: "text", // Especificar el tipo de datos que esperas recibir
            success: function(xmlResponse, status, xhr) {
                var detalles = $(xmlResponse).find('detalle');
        
                // Verificar si hay detalles
                if (detalles.length > 0) {
                    obtenerDetallesCotizacionContabilidad(detalles);
                } else {
                    // Manejar el caso en que no se encontraron detalles
                    $("#infoCotizacion").html("No se encontraron detalles para la cotización seleccionada.");
                }
    
                // Puedes acceder a detalles adicionales del objeto xhr, por ejemplo, los encabezados de la respuesta
                var encabezados = xhr.getAllResponseHeaders();
                console.log("Encabezados de la respuesta:", encabezados);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
                console.log("Detalles adicionales:", jqXHR.responseText);
            }
        });
    }

function detallesContabilidad(cotizacionID){
    sendXML(2, 'detallesContabilidad', '<cotizacionId>'+cotizacionID+'</cotizacionId>', detallesContabilidadAnswer);
}   

function detallesContabilidadAnswer(xml){
    if($('resultados', xml).text() == "0"){
        showAlerta('No se encontraron detalles para la contabilidad de este contrato.', 3);
        return;
    }
    let html = '';
    let documentoId = $('idCotizacion', xml).text();
    let fechaCotizacion = [""];
    let fechaCotizacionAux = $('fechaCotizacion', xml);
    // Iterar sobre los elementos obtenidos y concatenarlos al array fechaCotizacion
    for (let i = 0; i < fechaCotizacionAux.length; i++) {
        fechaCotizacion.push($(fechaCotizacionAux[i]).text());
    }
    let alcanceObra = $('alcanceObra', xml).text();
    let porcentajesPago = [""];
    let elementosPorcentajes = $('porcentajesPago', xml);
    // Iterar sobre los elementos obtenidos y concatenarlos al array porcentajesPago
    for (let i = 0; i < elementosPorcentajes.length; i++) {
        porcentajesPago.push($(elementosPorcentajes[i]).text());
    }
    let valoresPago = [""];
    let valoresPagos = $('valoresPago', xml);
    // Iterar sobre los elementos obtenidos y concatenarlos al array valoresPago
    for (let i = 0; i < valoresPagos.length; i++) {
        valoresPago.push($(valoresPagos[i]).text());
    }
    let manoObra = $('manoObra', xml).text();
    let porcentajeAdmin = $('porcentajeAdmin', xml).text();
    let porcentajeUtilidad = $('porcentajeUtilidad', xml).text();
    let alquilerEquipos = $('alquilerEquipos', xml).text();
    let transporte = $('transporte', xml).text();
    let elementosProteccion = $('elementosProteccion', xml).text();
    let Dotacion = $('Dotacion', xml).text();
    html = '<h3 style="font-weight:bold">'+alcanceObra+'</h3>';
    let botonModalPago = [];
     
    html += '<style>\
    .tablaContabilidadContrato {\
      width: 100%;\
      border: 1px solid black;\
      border-collapse: collapse;\
      margin-top: 20px;\
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);\
    }\
    \
    .tablaContabilidadContrato th,\
    .tablaContabilidadContrato td {\
      padding: 12px;\
      text-align: center;\
    }\
    \
    .tablaContabilidadContrato th {\
      background-color: #007bff;\
      color: #ffffff;\
    }\
    \
    .tablaContabilidadContrato tbody tr:nth-child(even) {\
      background-color: #f8f9fa;\
    }\
    \
    .tablaContabilidadContrato .total-row {\
      font-weight: bold;\
      background-color: #343a40;\
      color: #ffffff;\
    }\
    </style>';
    for (let i = 0; i < porcentajesPago.length; i++) {
        if (porcentajesPago[i] == "") {
            continue;
        }
        if (valoresPago[i] == 0 || valoresPago[i] == "") {
            showAlerta('No se pudo generar la contabilidad del pago ' + i + ', su valor es 0.', 3);
            continue;
        }
        botonModalPago[i] += $(valoresPago[i]).text() == 0;
        let manoObraValor = calcularPorcentaje(manoObra, porcentajesPago[i]);
        let porcentajeAdminValor = calcularPorcentaje(porcentajeAdmin, porcentajesPago[i]);
        let porcentajeUtilidadValor = calcularPorcentaje(porcentajeUtilidad, porcentajesPago[i]);
        let alquilerEquiposValor = calcularPorcentaje(alquilerEquipos, porcentajesPago[i]);
        let transporteValor = calcularPorcentaje(transporte, porcentajesPago[i]);
        let elementosProteccionValor = calcularPorcentaje(elementosProteccion, porcentajesPago[i]);
        let dotacionValor = calcularPorcentaje(Dotacion, porcentajesPago[i]);
        let valoresADiscriminar = [manoObraValor, porcentajeAdminValor, porcentajeUtilidadValor, alquilerEquiposValor, transporteValor, elementosProteccionValor, dotacionValor];
        let discriminacionPreciosHTML = discriminarPorPreciosNuevo(valoresPago[i], valoresADiscriminar, i);
        // Agregar los valores al HTML
        html += '<div style="overflow-x:auto;">'; // Div para el scroll horizontal
        html += '<table class="table table-responsive tablaContabilidadContrato">';
        html += '<thead>';
        html += '<tr>';
        html += '<th colspan="11" class="card-header">DISCRIMINACIÓN DE PRECIOS ' + alcanceObra + '</th>';
        html += '</tr>';
        html += '<tr>';
        html += '<th></th>';
        html += '<th>Fecha</th>';
        html += '<th>Porcentaje</th>';
        html += '<th>Valor pagado</th>';
        html += '<th>Mano de obra</th>';
        html += '<th>Porcentaje admin</th>';
        html += '<th>Porcentaje utilidad</th>';
        html += '<th>Alquiler de equipos</th>';
        html += '<th>Transporte</th>';
        html += '<th>Elementos de protección</th>';
        html += '<th>Dotacion</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        html += '<tr>';
        html += '<td rowspan=2>';
        html += '<button onclick="openModal(\'modalP' + i + '\');consultarDatosModalGastos(\'modalP' + i + '\')" class="btn btn-primary btn-sm" ' + (botonModalPago[i] ? 'disabled' : '') + '>Gastos</button>';
        html += '</td>';
        html += '<td rowspan=2>' + fechaCotizacion[i] + '</td>';
        html += '<td rowspan=2>' + porcentajesPago[i] + '</td>';
        html += '<td rowspan=2>' + valoresPago[i] + '</td>';
        html += '<td id="manoObra">' + manoObraValor + '</td>';
        html += '<td id="porcentajeAdmin">' + porcentajeAdminValor + '</td>';
        html += '<td id="porcentajeUtilidad">' + porcentajeUtilidadValor + '</td>';
        html += '<td id="alquilerEquipos">' + alquilerEquiposValor + '</td>';
        html += '<td id="transporte">' + transporteValor + '</td>';
        html += '<td id="elementosProteccion">' + elementosProteccionValor + '</td>';
        html += '<td id="Dotacion">' + dotacionValor + '</td>';
        html += '</tr>';
        html += '<tr>';
        html += discriminacionPreciosHTML;
        html += '</tr>';
        html += '</tbody>';
        html += '</table>';
        html += '</div>'; // Cerrar el div para el scroll horizontal
    
        // Construir el modal
        html += '<div id="modalP' + i + '" class="modal" onclick="closeModal();">';
        html += '<div class="modal-content" style="width: 38%;" onclick="event.stopPropagation();">';
        html += '<span class="close" onclick="closeModal(\'modalP' + i + '\');">&times;</span>';
        html += '<div style="text-align: center;">';
        html += '<b><h3 class="text-dark">Agregar gastos</h3></b>';
        html += '</div>';
        html += '<button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje' + i + '\')">+</button>';
        html += '<table id="tablaPorcentaje' + i + '">';
        html += '<tbody>';
        html += '<tr>';
        html += '<td>';
        html += '<div class="row">';
        html += '<div class="col-lg-6">';
        html += '<label for="producto"><b>Producto</b></label>';
        html += '<input type="text" class="form-control campoFormulario obligatorio" id="producto">';
        html += '</div>';
        html += '<div class="col-lg-6">';
        html += '<label for="precio"><b>Precio</b></label>';
        html += '<input type="hidden" id="rowCountModal" class="campoFormulario" value="1">';
        html += '<input type="hidden" id="numeralPorcentaje" class="campoFormulario" value="' + i + '">';
        html += '<input type="hidden" class="campoFormulario obligatorio" value="' + porcentajesPago[i] + '" id="porcentaje">';
        html += '<input type="hidden" class="campoFormulario obligatorio" value="' + documentoId + '" id="idContrato">';
        html += '<input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante' + i + '\', \'valorPorcentaje1Original\');">';
        html += '</div>';
        html += '</div>';
        html += '</td>';
        html += '</tr>';
        html += '</tbody>';
        html += '</table>';
        html += '<br>';
        html += '<button class="btn btn-success" onclick="guardarGastos(\'#tablaPorcentaje' + i + '\', \'#totalRestante' + i + '\')">Guardar</button>';
        html += '</div>';
        html += '</div>';
        $('#infoCotizacion').html(html);
    }
    
}

function discriminarPorPreciosNuevo(valor, porcentajes, numero) {
    if(valor == 0){
        return;
    }
    valor = eliminarPuntosYConvertirAFloat(valor);
    let manoObraDiscriminada = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[0]));
    valor -= manoObraDiscriminada;
    let porcentajeAdminDiscriminacion = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[1]));
    valor -= porcentajeAdminDiscriminacion;
    let porcentajeUtilidadDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[2]));
    valor -= porcentajeUtilidadDiscriminado;
    let alquilerEquiposDiscriminados = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[3]));
    valor -= alquilerEquiposDiscriminados;
    let transporteDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[4]));
    valor -= transporteDiscriminado;
    let elementosProteccionDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[5]));
    valor -= elementosProteccionDiscriminado;
    let DotacionDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[6]));
    valor -= DotacionDiscriminado;
    let manoObraHtml = '<td id="manoObraDiscriminacion'+numero+'">' + formatoPesoColombianoReturn(manoObraDiscriminada) + '</td>';
    let porcentajeAdminHtml = '<td id="porcentajeAdminDiscriminacion'+numero+'">' + formatoPesoColombianoReturn(porcentajeAdminDiscriminacion) + '</td>';
    let porcentajeUtilidadHtml = '<td id="porcentajeUtilidadDiscriminado'+numero+'">' + formatoPesoColombianoReturn(porcentajeUtilidadDiscriminado) + '</td>';
    let alquilerEquiposHtml = '<td id="alquilerEquiposDiscriminados'+numero+'">' + formatoPesoColombianoReturn(alquilerEquiposDiscriminados) + '</td>';
    let transporteHtml = '<td id="transporteDiscriminado'+numero+'">' + formatoPesoColombianoReturn(transporteDiscriminado) + '</td>';
    let elementosProteccionHtml = '<td id="elementosProteccionDiscriminado'+numero+'">' + formatoPesoColombianoReturn(elementosProteccionDiscriminado) + '</td>';
    let DotacionHtml = '<td id="DotacionDiscriminado'+numero+'">' + formatoPesoColombianoReturn(DotacionDiscriminado) + '</td>';
    let totalRestanteHtml = '</tr><tr><td colspan="11" id="totalRestante'+numero+'"><h3>Total restante:</h3>' + formatoPesoColombianoReturn(valor) + '</td>';
    return manoObraHtml + porcentajeAdminHtml + porcentajeUtilidadHtml + alquilerEquiposHtml + transporteHtml + elementosProteccionHtml + DotacionHtml + totalRestanteHtml;
}

function calcularPorcentaje(valor, porcentaje){
    if(valor == 0 || porcentaje == 0){
        return 0;
    }
    if (typeof valor === 'string' && valor.includes('%')) {
        return valor;
    }
    valor = eliminarPuntosYConvertirAFloat(valor);
    if (typeof porcentaje === 'string' && porcentaje.includes('%')) {
        porcentaje = parseInt(porcentaje.replace('%', ''));
        valor = Math.round((porcentaje / 100) * valor);
        return formatoPesoColombianoReturn(valor);
    }
    return formatoPesoColombianoReturn(porcentaje);
}

let valorPorcentaje1Original = 0;
let valorPorcentaje2Original = 0;
let valorPorcentaje3Original = 0;
let valorPorcentaje4Original = 0;

function obtenerDetallesCotizacionContabilidad(detalles){
    let html = '';
    let documentoId = detalles.find('idCotizacion').text();
    let alcanceObra = detalles.find('alcanceObra').text();
    let fechaCotizacion = detalles.find('fechaCotizacion').text();
    let porcentaje1 = detalles.find('porcentaje1').text();
    let porcentaje2 = detalles.find('porcentaje2').text();
    let porcentaje3 = detalles.find('porcentaje3').text();
    let porcentaje4 = detalles.find('porcentaje4').text();
    let valorPago1 = detalles.find('valorPago1').text();
    let valorPago2 = detalles.find('valorPago2').text();
    let valorPago3 = detalles.find('valorPago3').text();
    let valorPago4 = detalles.find('valorPago4').text();
    let manoObra = detalles.find('manoObra').text();
    let porcentajeAdmin = detalles.find('porcentajeAdmin').text();
    let porcentajeUtilidad = detalles.find('porcentajeUtilidad').text();
    let alquilerEquipos = detalles.find('alquilerEquipos').text();
    let transporte = detalles.find('transporte').text();
    let elementosProteccion = detalles.find('elementosProteccion').text();
    let Dotacion = detalles.find('Dotacion').text();
    html = '<h3 style="font-weight:bold">'+alcanceObra+'</h3>';
    let botonModalPago1 = valorPago1 == 0; 
    let botonModalPago2 = valorPago2 == 0; 
    let botonModalPago3 = valorPago3 == 0; 
    let botonModalPago4 = valorPago4 == 0; 

    html = '<style>\
    .tablaContabilidadContrato {\
      width: 100%;\
      border: 1px solid black;\
      border-collapse: collapse;\
      margin-top: 20px;\
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);\
    }\
    \
    .tablaContabilidadContrato th,\
    .tablaContabilidadContrato td {\
      padding: 12px;\
      text-align: center;\
    }\
    \
    .tablaContabilidadContrato th {\
      background-color: #007bff;\
      color: #ffffff;\
    }\
    \
    .tablaContabilidadContrato tbody tr:nth-child(even) {\
      background-color: #f8f9fa;\
    }\
    \
    .tablaContabilidadContrato .total-row {\
      font-weight: bold;\
      background-color: #343a40;\
      color: #ffffff;\
    }\
  </style>\
  <table class="table table-responsive tablaContabilidadContrato">\
    <thead>\
      <tr>\
        <th colspan="11" class="card-header">DISCRIMINACIÓN DE PRECIOS '+alcanceObra+'</th>\
      </tr>\
      <tr>\
        <th></th>\
        <th>Fecha</th>\
        <th>Porcentaje</th>\
        <th>Valor pagado</th>\
        <th>Mano de obra</th>\
        <th>Porcentaje admin</th>\
        <th>Porcentaje utilidad</th>\
        <th>Alquiler de equipos</th>\
        <th>Transporte</th>\
        <th>Elementos de protección</th>\
        <th>Dotacion</th>\
      </tr>\
    </thead>\
    <tbody>\
      <tr>\
        <td rowspan=2>\
        <button onclick="openModal(\'modalP1\');consultarDatosModalGastos(\'modalP1\')" class="btn btn-primary btn-sm" ' + (botonModalPago1 ? 'disabled' : '') + '>Gastos</button>\
        </td>\
        <td rowspan=2>'+fechaCotizacion+'</td>\
        <td rowspan=2>'+porcentaje1+'</td>\
        <td rowspan=2>'+valorPago1+'</td>\
        <td>'+manoObra+'</td>\
        <td>'+porcentajeAdmin+'</td>\
        <td>'+porcentajeUtilidad+'</td>\
        <td>'+alquilerEquipos+'</td>\
        <td>'+transporte+'</td>\
        <td>'+elementosProteccion+'</td>\
        <td>'+Dotacion+'</td>\
      </tr>\
      <tr>\
        <td id="manoObraDiscriminacion1"></td>\
        <td id="porcentajeAdminDiscriminacion1"></td>\
        <td id="porcentajeUtilidadDiscriminado1"></td>\
        <td id="alquilerEquiposDiscriminados1"></td>\
        <td id="transporteDiscriminado1"></td>\
        <td id="elementosProteccionDiscriminado1"></td>\
        <td id="DotacionDiscriminado1"></td>\
      </tr>\
      <tr>\
        <td colspan="11" id="totalRestante1"></td>\
      </tr>\
    </tbody>\
  </table>';
// Modal
html += '<div id="modalP1" class="modal" onclick="closeModal();">\
            <div class="modal-content" style="width: 38%;" onclick="event.stopPropagation();">\
                <span class="close" onclick="closeModal(\'modalP1\');">&times;</span>\
                <div style="text-align: center;">\
                    <b><h3 class="text-dark">Agregar gastos</h3></b>\
                </div>\
                <button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje1\')">+</button>\
                <table id="tablaPorcentaje1">\
                    <tbody>\
                        <tr>\
                            <td>\
                                <div class="row">\
                                    <div class="col-lg-6">\
                                        <label for="producto"><b>Producto</b></label>\
                                        <input type="text" class="form-control campoFormulario obligatorio" id="producto">\
                                    </div>\
                                    <div class="col-lg-6">\
                                        <label for="precio"><b>Precio</b></label>\
                                        <input type="hidden" id="rowCountModal" class="campoFormulario" value="1">\
                                        <input type="hidden" id="numeralPorcentaje" class="campoFormulario" value="1">\
                                        <input type="hidden" class="campoFormulario obligatorio" value="'+porcentaje1+'" id="porcentaje">\
                                        <input type="hidden" class="campoFormulario obligatorio" value="'+documentoId+'" id="idContrato">\
                                        <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante1\', \'valorPorcentaje1Original\');">\
                                    </div>\
                                </div>\
                            </td>\
                        </tr>\
                    </tbody>\
                </table>\
                <br>\
                <button class="btn btn-success" onclick="guardarGastos(\'#tablaPorcentaje1\', \'#totalRestante1\')">Guardar</button>\                </div>\
        </div>';
    html += '<table class="table table-responsive tablaContabilidadContrato">\
    <thead>\
        <tr>\
        <th colspan="11" class="card-header">DISCRIMINACIÓN DE PRECIOS '+alcanceObra+'</th>\
        </tr>\
        <tr>\
        <th></th>\
        <th>Fecha</th>\
        <th>Porcentaje</th>\
        <th>Valor pagado</th>\
        <th>Mano de obra</th>\
        <th>Porcentaje admin</th>\
        <th>Porcentaje utilidad</th>\
        <th>Alquiler de equipos</th>\
        <th>Transporte</th>\
        <th>Elementos de protección</th>\
        <th>Dotacion</th>\
        </tr>\
    </thead>\
    <tbody>\
        <tr>\
        <td rowspan=2>\
        <button onclick="openModal(\'modalP2\');consultarDatosModalGastos(\'modalP2\')" class="btn btn-primary btn-sm" ' + (botonModalPago2 ? 'disabled' : '') + '>Gastos</button>\
        </td>\
        <td rowspan=2>'+fechaCotizacion+'</td>\
        <td rowspan=2>'+porcentaje2+'</td>\
        <td rowspan=2>'+valorPago2+'</td>\
        <td>'+manoObra+'</td>\
        <td>'+porcentajeAdmin+'</td>\
        <td>'+porcentajeUtilidad+'</td>\
        <td>'+alquilerEquipos+'</td>\
        <td>'+transporte+'</td>\
        <td>'+elementosProteccion+'</td>\
        <td>'+Dotacion+'</td>\
        </tr>\
        <tr>\
        <td id="manoObraDiscriminacion2"></td>\
        <td id="porcentajeAdminDiscriminacion2"></td>\
        <td id="porcentajeUtilidadDiscriminado2"></td>\
        <td id="alquilerEquiposDiscriminados2"></td>\
        <td id="transporteDiscriminado2"></td>\
        <td id="elementosProteccionDiscriminado2"></td>\
        <td id="DotacionDiscriminado2"></td>\
        </tr>\
        <tr>\
        <td colspan="11" id="totalRestante2"></td>\
        </tr>\
    </tbody>\
    </table>';
    // Modal
    html += '<div id="modalP2" class="modal" onclick="closeModal(\'modalP2\');">\
                <div class="modal-content" style="width: 38%;" onclick="event.stopPropagation();">\
                    <span class="close" onclick="closeModal(\'modalP2\');">&times;</span>\
                    <div style="text-align: center;">\
                        <b><h3 class="text-dark">Agregar gastos</h3></b>\
                    </div>\
                    <button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje2\')">+</button>\
                    <table id="tablaPorcentaje2">\
                        <tbody>\
                            <tr>\
                                <td>\
                                    <div class="row">\
                                        <div class="col-lg-6">\
                                            <label for="producto"><b>Producto</b></label>\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="producto">\
                                        </div>\
                                        <div class="col-lg-6">\
                                            <label for="precio"><b>Precio</b></label>\
                                            <input type="hidden" id="rowCountModal" class="campoFormulario" value="1">\
                                            <input type="hidden" id="numeralPorcentaje" class="campoFormulario" value="2">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+porcentaje2+'" id="porcentaje">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+documentoId+'" id="idContrato">\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante2\', valorPorcentaje2Original);">\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>\
                        </tbody>\
                    </table>\
                    <br>\
                    <button class="btn btn-success" onclick="guardarGastos(\'#tablaPorcentaje2\', \'#totalRestante2\')">Guardar</button>\                </div>\
            </div>';
        html += '<table class="table table-responsive tablaContabilidadContrato">\
        <thead>\
        <tr>\
        <th colspan="11" class="card-header">DISCRIMINACIÓN DE PRECIOS '+alcanceObra+'</th>\
        </tr>\
        <tr>\
        <th></th>\
        <th>Fecha</th>\
        <th>Porcentaje</th>\
        <th>Valor pagado</th>\
        <th>Mano de obra</th>\
        <th>Porcentaje admin</th>\
        <th>Porcentaje utilidad</th>\
        <th>Alquiler de equipos</th>\
        <th>Transporte</th>\
        <th>Elementos de protección</th>\
        <th>Dotacion</th>\
      </tr>\
    </thead>\
    <tbody>\
        <tr>\
        <td rowspan=2>\
        <button onclick="openModal(\'modalP3\');consultarDatosModalGastos(\'modalP3\')" class="btn btn-primary btn-sm" ' + (botonModalPago3 ? 'disabled' : '') + '>Gastos</button>\
        </td>\
        <td rowspan=2>'+fechaCotizacion+'</td>\
        <td rowspan=2>'+porcentaje3+'</td>\
        <td rowspan=2>'+valorPago3+'</td>\
        <td>'+manoObra+'</td>\
        <td>'+porcentajeAdmin+'</td>\
        <td>'+porcentajeUtilidad+'</td>\
        <td>'+alquilerEquipos+'</td>\
        <td>'+transporte+'</td>\
        <td>'+elementosProteccion+'</td>\
        <td>'+Dotacion+'</td>\
      </tr>\
      <tr>\
        <td id="manoObraDiscriminacion3"></td>\
        <td id="porcentajeAdminDiscriminacion3"></td>\
        <td id="porcentajeUtilidadDiscriminado3"></td>\
        <td id="alquilerEquiposDiscriminados3"></td>\
        <td id="transporteDiscriminado3"></td>\
        <td id="elementosProteccionDiscriminado3"></td>\
        <td id="DotacionDiscriminado3"></td>\
      </tr>\
      <tr>\
        <td colspan="11" id="totalRestante3"></td>\
    </tr>\
    </tbody>\
  </table>';
  html += '<div id="modalP3" class="modal" onclick="closeModal(\'modalP3\');">\
                <div class="modal-content" style="width: 38%;" onclick="event.stopPropagation();">\
                    <span class="close" onclick="closeModal(\'modalP3\');">&times;</span>\
                    <div style="text-align: center;">\
                        <b><h3 class="text-dark">Agregar gastos</h3></b>\
                    </div>\
                    <button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje3\')">+</button>\
                    <table id="tablaPorcentaje3">\
                        <tbody>\
                            <tr>\
                                <td>\
                                    <div class="row">\
                                        <div class="col-lg-6">\
                                            <label for="producto"><b>Producto</b></label>\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="producto">\
                                        </div>\
                                        <div class="col-lg-6">\
                                            <label for="precio"><b>Precio</b></label>\
                                            <input type="hidden" id="rowCountModal" class="campoFormulario" value="1">\
                                            <input type="hidden" id="numeralPorcentaje" class="campoFormulario" value="3">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+porcentaje3+'" id="porcentaje">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+documentoId+'" id="idContrato">\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante3\', valorPorcentaje3Original);">\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>\
                        </tbody>\
                    </table>\
                    <br>\
                    <button class="btn btn-success" onclick="guardarGastos(\'#tablaPorcentaje3\', \'#totalRestante3\')">Guardar</button>\                </div>\
            </div>';
  html += '<table class="table table-responsive tablaContabilidadContrato">\
  <thead>\
      <tr>\
      <th colspan="11" class="card-header">DISCRIMINACIÓN DE PRECIOS '+alcanceObra+'</th>\
      </tr>\
      <tr>\
      <th></th>\
      <th>Fecha</th>\
      <th>Porcentaje</th>\
      <th>Valor pagado</th>\
      <th>Mano de obra</th>\
      <th>Porcentaje admin</th>\
      <th>Porcentaje utilidad</th>\
      <th>Alquiler de equipos</th>\
      <th>Transporte</th>\
      <th>Elementos de protección</th>\
      <th>Dotacion</th>\
    </tr>\
  </thead>\
  <tbody>\
  <tr>\
      <td rowspan=2>\
      <button onclick="openModal(\'modalP4\');consultarDatosModalGastos(\'modalP4\')" class="btn btn-primary btn-sm" ' + (botonModalPago4 ? 'disabled' : '') + '>Gastos</button>\
      </td>\
      <td rowspan=2>'+fechaCotizacion+'</td>\
      <td rowspan=2>'+porcentaje4+'</td>\
      <td rowspan=2>'+valorPago4+'</td>\
      <td>'+manoObra+'</td>\
      <td>'+porcentajeAdmin+'</td>\
      <td>'+porcentajeUtilidad+'</td>\
      <td>'+alquilerEquipos+'</td>\
      <td>'+transporte+'</td>\
      <td>'+elementosProteccion+'</td>\
      <td>'+Dotacion+'</td>\
    </tr>\
    <tr>\
      <td id="manoObraDiscriminacion4"></td>\
      <td id="porcentajeAdminDiscriminacion4"></td>\
      <td id="porcentajeUtilidadDiscriminado4"></td>\
      <td id="alquilerEquiposDiscriminados4"></td>\
      <td id="transporteDiscriminado4"></td>\
      <td id="elementosProteccionDiscriminado4"></td>\
      <td id="DotacionDiscriminado4"></td>\
    </tr>\
    <tr>\
      <td colspan="11" id="totalRestante4"></td>\
    </tr>\
  </tbody>\
</table>';
  html += '<div id="modalP4" class="modal" onclick="closeModal(\'modalP4\');">\
                <div class="modal-content" style="width: 38%;" onclick="event.stopPropagation();">\
                    <span class="close" onclick="closeModal(\'modalP4\');">&times;</span>\
                    <div style="text-align: center;">\
                        <b><h3 class="text-dark">Agregar gastos</h3></b>\
                    </div>\
                    <button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje4\')">+</button>\
                    <table id="tablaPorcentaje4">\
                        <tbody>\
                            <tr>\
                                <td>\
                                    <div class="row">\
                                        <div class="col-lg-6">\
                                            <label for="producto"><b>Producto</b></label>\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="producto">\
                                        </div>\
                                        <div class="col-lg-6">\
                                            <label for="precio"><b>Precio</b></label>\
                                            <input type="hidden" id="rowCountModal" class="campoFormulario" value="1">\
                                            <input type="hidden" id="numeralPorcentaje" class="campoFormulario" value="4">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+porcentaje4+'" id="porcentaje">\
                                            <input type="hidden" class="campoFormulario obligatorio" value="'+documentoId+'" id="idContrato">\
                                            <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante4\', valorPorcentaje4Original);">\
                                        </div>\
                                    </div>\
                                </td>\
                            </tr>\
                        </tbody>\
                    </table>\
                    <br>\
                    <button class="btn btn-success" onclick="guardarGastos(\'#tablaPorcentaje4\', \'#totalRestante4\')">Guardar</button>\                </div>\
            </div>';
    let arrayValoresAdicionales = [manoObra, porcentajeAdmin, porcentajeUtilidad, alquilerEquipos, transporte, elementosProteccion, Dotacion]
    $("#infoCotizacion").html(html);
    discriminarPorPrecios(valorPago1, arrayValoresAdicionales, 1);
    discriminarPorPrecios(valorPago2, arrayValoresAdicionales, 2);
    discriminarPorPrecios(valorPago3, arrayValoresAdicionales, 3);
    discriminarPorPrecios(valorPago4, arrayValoresAdicionales, 4);
    let valorTotalPorcentaje1 = $('#totalRestante1').text().match(/-?\d+(\.\d+)?/);
    let valorTotalPorcentaje2 = $('#totalRestante2').text().match(/-?\d+(\.\d+)?/);
    let valorTotalPorcentaje3 = $('#totalRestante3').text().match(/-?\d+(\.\d+)?/);
    let valorTotalPorcentaje4 = $('#totalRestante4').text().match(/-?\d+(\.\d+)?/);
    valorPorcentaje1Original = valorTotalPorcentaje1 ? valorTotalPorcentaje1[0] : null;
    valorPorcentaje2Original = valorTotalPorcentaje2 ? valorTotalPorcentaje2[0] : null;
    valorPorcentaje3Original = valorTotalPorcentaje3 ? valorTotalPorcentaje3[0] : null;
    valorPorcentaje4Original = valorTotalPorcentaje4 ? valorTotalPorcentaje4[0] : null;
}
function openModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = 'block';
}

function closeModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = 'none';
}

function calcularGastosContabilidad(campo, totalAntesDe, porcentajeOriginal) {
    let valorTotalAntesDe = $('#' + totalAntesDe).text();
    let soloNumeros = valorTotalAntesDe.match(/-?\d+(\.\d+)?/);
    let numeroExtraido = soloNumeros ? soloNumeros[0] : null;
    numeroExtraido = eliminarPuntosYConvertirAFloat(numeroExtraido);

    // Obtener el valor del campo de la fila eliminada
    let valorCampo = eliminarPuntosYConvertirAFloat($(campo).val());

    // Establecer valorCampo en 0 si el primer campo que incluye la palabra "precio" está vacío
    valorCampo = isNaN(valorCampo) ? 0 : valorCampo;

    let tabla = $(campo).closest('table');
    if (tabla.find('tbody tr').length === 1 && valorCampo === 0) {
        // Restaurar al valor anterior
        $('#' + totalAntesDe).html('<h3>Total restante:</h3>' + formatoPesoColombianoReturn(porcentajeOriginal));
    } else {
        if (deleteFila) {
            $('#' + totalAntesDe).html('<h3>Total restante:</h3>' + formatoPesoColombianoReturn(numeroExtraido + valorCampo));
            deleteFila = false;
            return;
        }
        $('#' + totalAntesDe).html('<h3>Total restante:</h3>' + formatoPesoColombianoReturn(numeroExtraido - valorCampo));
    }
}

function discriminarPorPrecios(valor, porcentajes, numero) {
    if(valor == 0){
        return;
    }
    valor = eliminarPuntosYConvertirAFloat(valor);
    let manoObraDiscriminada = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[0]));
    valor -= manoObraDiscriminada;
    let porcentajeAdminDiscriminacion = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[1]));
    valor -= porcentajeAdminDiscriminacion;
    let porcentajeUtilidadDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[2]));
    valor -= porcentajeUtilidadDiscriminado;
    let alquilerEquiposDiscriminados = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[3]));
    valor -= alquilerEquiposDiscriminados;
    let transporteDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[4]));
    valor -= transporteDiscriminado;
    let elementosProteccionDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[5]));
    valor -= elementosProteccionDiscriminado;
    let DotacionDiscriminado = eliminarPuntosYConvertirAFloat(calcularPorcentaje(valor, porcentajes[6]));
    valor -= DotacionDiscriminado;
    $('#manoObraDiscriminacion'+numero).html(formatoPesoColombianoReturn(manoObraDiscriminada));
    $('#porcentajeAdminDiscriminacion'+numero).html(formatoPesoColombianoReturn(porcentajeAdminDiscriminacion));
    $('#porcentajeUtilidadDiscriminado'+numero).html(formatoPesoColombianoReturn(porcentajeUtilidadDiscriminado));
    $('#alquilerEquiposDiscriminados'+numero).html(formatoPesoColombianoReturn(alquilerEquiposDiscriminados));
    $('#transporteDiscriminado'+numero).html(formatoPesoColombianoReturn(transporteDiscriminado));
    $('#elementosProteccionDiscriminado'+numero).html(formatoPesoColombianoReturn(elementosProteccionDiscriminado));
    $('#DotacionDiscriminado'+numero).html(formatoPesoColombianoReturn(DotacionDiscriminado));
    $('#totalRestante'+numero).html('<h3>Total restante:</h3>'+formatoPesoColombianoReturn(valor));
}

function generarContrato(cotizacion){
    if(cotizacion == '' || cotizacion == undefined){
        return;
    }
    let data = {
        cotizacionID: cotizacion,
        accion: "actualizarEstadoContrato"
    };

    $.ajax({
        url: "action.php", // Archivo PHP que maneja la consulta a la base de datos
        method: "POST",
        data: data,
        success: function (data) {
            try {
                const jsonResponse = JSON.parse(data); // Intenta analizar la respuesta como JSON
                if (jsonResponse.success === true) {
                    mostrarAlertas([jsonResponse.message], "success");
                } else if (jsonResponse.danger === true) {
                    mostrarAlertas([jsonResponse.message], "danger");
                } 
            } catch (e) {

            }
        },
        error: function (error) {
            mostrarAlertas(["Hubo un error al eliminar la fila"], "danger");
        }
    });
}

function cargarContratos(){
    let campo = $('#cotizacionSelect');
    var selectedCotizacion = $(campo).val();
    if(selectedCotizacion !== "") {
        sendXML(1, 'obtenerCotizacion', '<idCotizacion>'+selectedCotizacion+'</idCotizacion>', cargarContratosAnswer);
    }else{
        $('#pagoValorContrato :input').val('');
        $('#pagoValorContrato').hide();
    }
}

function cargarContratosAnswer(xml){
    if($('respuesta', xml).text() === "OK"){
        $('#documentoId').val($('documentoId', xml).text());
        $('#pagoPorcentaje1').val($('porcentaje1', xml).text());
        $('#pagoPorcentaje2').val($('porcentaje2', xml).text());
        $('#pagoPorcentaje3').val($('porcentaje3', xml).text());
        $('#pagoPorcentaje4').val($('porcentaje4', xml).text());
        $('#fechaPagado1').val($('fechaPago1', xml).text());
        $('#fechaPagado2').val($('fechaPago2', xml).text());
        $('#fechaPagado3').val($('fechaPago3', xml).text());
        $('#fechaPagado4').val($('fechaPago4', xml).text());

        let valorPago1 = $('valorPago1', xml).text();
        let valorPago2 = $('valorPago2', xml).text();
        let valorPago3 = $('valorPago3', xml).text();
        let valorPago4 = $('valorPago4', xml).text();  
        if(valorPago1 == ""){
            valorPago1 = calcularPagoContrato('#valorPago1', $('porcentaje1', xml).text(), $('valorTotalCotizacion', xml).text());
        }
        if(valorPago2 == ""){
            valorPago2 = calcularPagoContrato('#valorPago2', $('porcentaje2', xml).text(), $('valorTotalCotizacion', xml).text());
        }
        if(valorPago3 == ""){
            valorPago3 = calcularPagoContrato('#valorPago3', $('porcentaje3', xml).text(), $('valorTotalCotizacion', xml).text());
        }
        if(valorPago4 == ""){
            valorPago4 = calcularPagoContrato('#valorPago4', $('porcentaje4', xml).text(), $('valorTotalCotizacion', xml).text());
        }
        $('#valorPago1').val(valorPago1);
        $('#valorPago2').val(valorPago2);
        $('#valorPago3').val(valorPago3);
        $('#valorPago4').val(valorPago4);
        if(!vacio(valorPago1) || !vacio(valorPago2) || !vacio(valorPago3) || !vacio(valorPago4)){
            $('#guardarPagosCotizacion').attr('onclick', 'editarPagoContrato()');
            calcularTotalRestarContrato($('valorTotalCotizacion', xml).text(), $('#valorPago1'), $('#valorPago2'), $('#valorPago3'), $('#valorPago4'));
        }
        let pagado1 = $('pagado1', xml).text() === "true" ? true : false;
        let pagado2 = $('pagado2', xml).text() === "true" ? true : false;
        let pagado3 = $('pagado3', xml).text() === "true" ? true : false;
        let pagado4 = $('pagado4', xml).text() === "true" ? true : false;
        $('#valorTotalCotizacion').text($('valorTotalCotizacion', xml).text());
        if ($('#checkboxPagado1').prop('checked', pagado1)) {
            $('#checkboxPagado1').trigger('change');
        }
        if ($('#checkboxPagado2').prop('checked', pagado2)) {
            $('#checkboxPagado2').trigger('change');
        }
        if ($('#checkboxPagado3').prop('checked', pagado3)) {
            $('#checkboxPagado3').trigger('change');
        }
        if ($('#checkboxPagado4').prop('checked', pagado4)) {
            $('#checkboxPagado4').trigger('change');
        }
        $('#pagoValorContrato').show();
    }
}

function calcularPagoContrato(idCampo, porcentaje, valorTotalContrato){
    return formatoPesoColombianoReturn(Math.round(eliminarPuntosYConvertirAFloat(valorTotalContrato) * (eliminarPuntosYConvertirAFloat(porcentaje) / 100)));
}

function calcularTotalRestarContrato(totalContrato, valores){
    totalContrato = eliminarPuntosYConvertirAFloat(totalContrato);
    let restante = totalContrato;
    for(let i = 0; i < valores.length; i++){
        let campo = $(valores[i]);
        let isDisabled = $(campo).prop('disabled');
        if(isDisabled){
            continue;
        }
        let valorCampo = eliminarPuntosYConvertirAFloat($(campo).val());
        restante -= valorCampo;
    }
    $('#valorRestante').text(formatoPesoColombianoReturn(restante));
}

function editarPagoContrato(){
    let cotizacionId = $('#documentoId').val();
    let valorPago1 = $('#valorPago1').prop('disabled') ? '' : $('#valorPago1').val();
    let valorPago2 = $('#valorPago2').prop('disabled') ? '' : $('#valorPago2').val();
    let valorPago3 = $('#valorPago3').prop('disabled') ? '' : $('#valorPago3').val();
    let valorPago4 = $('#valorPago4').prop('disabled') ? '' : $('#valorPago4').val();
    let fechaPago1 = $('#fechaPagado1').prop('disabled') ? '' : $('#fechaPagado1').val();
    let fechaPago2 = $('#fechaPagado2').prop('disabled') ? '' : $('#fechaPagado2').val();
    let fechaPago3 = $('#fechaPagado3').prop('disabled') ? '' : $('#fechaPagado3').val();
    let fechaPago4 = $('#fechaPagado4').prop('disabled') ? '' : $('#fechaPagado4').val();
    let pagado1 = $('#checkboxPagado1').prop('checked');
    let pagado2 = $('#checkboxPagado2').prop('checked');
    let pagado3 = $('#checkboxPagado3').prop('checked');
    let pagado4 = $('#checkboxPagado4').prop('checked');
    let param = '<cotizacionId>'+cotizacionId+'</cotizacionId>';
    param = param + '<valorPago1>'+valorPago1+'</valorPago1>';
    param = param + '<valorPago2>'+valorPago2+'</valorPago2>';
    param = param + '<valorPago3>'+valorPago3+'</valorPago3>';
    param = param + '<valorPago4>'+valorPago4+'</valorPago4>';
    param = param + '<fechaPagado1>'+fechaPago1+'</fechaPagado1>';
    param = param + '<fechaPagado2>'+fechaPago2+'</fechaPagado2>';
    param = param + '<fechaPagado3>'+fechaPago3+'</fechaPagado3>';
    param = param + '<fechaPagado4>'+fechaPago4+'</fechaPagado4>';
    param = param + '<pagado1>'+pagado1+'</pagado1>';
    param = param + '<pagado2>'+pagado2+'</pagado2>';
    param = param + '<pagado3>'+pagado3+'</pagado3>';
    param = param + '<pagado4>'+pagado4+'</pagado4>';
    sendXML(1, 'U-pagoContrato', param, editarPagoContratoAnswer);
}

function editarPagoContratoAnswer(xml){
    if($('respuesta',xml).text() === "OK"){
        mostrarAlertas(['Se ha actualizado el pago del contrato correctamente'], 'success');
    }
}

function consultarDatosModalGastos(modalId){
    setTimeout(function(){
        let rowCount = $('#rowCountModal', '#'+modalId).val();
        let numeralPorcentaje = $('#numeralPorcentaje', '#'+modalId).val();
        let porcentaje = $('#porcentaje', '#'+modalId).val();
        let documentoId = $('#idContrato', '#'+modalId).val();
        let param = '<modal>'+modalId+'</modal><rowCount>'+rowCount+'</rowCount><numeralPorcentaje>'+numeralPorcentaje+'</numeralPorcentaje><porcentaje>'+porcentaje+'</porcentaje><documentoId>'+documentoId+'</documentoId>';
        sendXML(2, 'S-gastosContratos', param, consultarDatosModalGastosAnswer);
    },500);
}

function consultarDatosModalGastosAnswer(xml) {
    let modalId = $('modal', xml).text();
    let modal = $('#' + modalId);
    let tablaId = $(modal).find('table').attr('id');
    let tabla = $('#' + tablaId);
    // Verificar si es necesario agregar filas
    if ($('producto', xml).length - 1 === tabla.find('tr').length) {
        return; // No es necesario agregar filas, salir de la función
    }
    campoAgregarFila('#' + tablaId, $('producto', xml).length - 1);
    let esEdicion = false;
    let productos = $('producto', xml);
    let precios = $('precio', xml);
    for (let index = 0; index < productos.length; index++) {
        let producto = productos.eq(index).text();
        let precio = precios.eq(index).text();
        // Verificar si los campos están vacíos antes de asignarles valores
        let productoCampo = tabla.find('tr:eq(' + index + ')').find('[id*=producto]');
        let precioCampo = tabla.find('tr:eq(' + index + ')').find('[id*=precio]');
        if (productoCampo.val() === "" && precioCampo.val() === "") {
            // Asignar los valores a los campos correspondientes en cada fila clonada solo si están vacíos
            productoCampo.val(producto);
            precioCampo.val(precio);
            esEdicion = true;
        }
    }
    if (esEdicion) {
        let botonGuardar = $('button[onclick^="guardarGastos("][onclick$=")"]', modal);
        if (botonGuardar.length > 0) {
            var nuevoOnclick = 'editarGastos("#' + tablaId + '", "")';
            // Cambiar el atributo onclick del botón
            $(botonGuardar).attr('onclick', nuevoOnclick);
        }
    }
    let filas = tabla.find('tr');
    for (let i = 0; i < filas.length; i++) {
        let productoCampo = $(filas[i]).find('[id*=producto]');
        let precioCampo = $(filas[i]).find('[id*=precio]');
        if (productoCampo.val() === "" && precioCampo.val() === "") {
            $(filas[i]).remove();
        }
    }
    $($('tdTotal',xml).text()).html('<h3>Total restante</h3> '+$('total', xml).text()+'');
}

