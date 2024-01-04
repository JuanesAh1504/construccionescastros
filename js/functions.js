document.write('<script src="js/jquery-3.7.1.min.js"></script>');

function agregarFila() {
    var rowCount = parseInt($("#rowCount").val());
    var newRow = $("<tr>");

    newRow.append($("<td><input type='text' class='inputPersonalizado campoFormulario' id='materiales_" + rowCount + "'></td>"));
    newRow.append($("<td><input type='text' class='inputPersonalizado campoFormulario' id='metrosUnidades_" + rowCount + "'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='precioUnitario_" + rowCount + "' onchange='formatoPesoColombiano(this);calcularFormula(\"cantidad_" + rowCount + "\", \"precioUnitario_" + rowCount + "\", \"precioTotal_" + rowCount + "\");calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales()'></td>"));
    newRow.append($("<td><input style='width:70px' type='text' class='inputPersonalizado campoFormulario campoNumero' id='cantidad_" + rowCount + "' value='1' onchange='calcularFormula(\"precioUnitario_" + rowCount + "\", \"cantidad_" + rowCount + "\", \"precioTotal_" + rowCount + "\");calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales()'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='precioTotal_" + rowCount + "' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='iva_" + rowCount + "' onchange='calcularIva(\"precioTotal_" + rowCount + "\", \"iva_" + rowCount + "\", \"totalIva_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales()'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalIva_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' class='inputPersonalizado campoFormulario' id='retefuente_" + rowCount + "' onchange='calcularRetefuente(\"precioTotal_" + rowCount + "\", \"retefuente_" + rowCount + "\", \"totalRetefuente_" + rowCount + "\");valorTotal([\"#precioTotal_" + rowCount + "\", \"#totalIva_" + rowCount + "\", \"#totalRetefuente_" + rowCount + "\"], \"totalPorTodo_" + rowCount + "\");sumarPrecioTotal();calcularCamposAdicionales()'></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalRetefuente_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='text' id='totalPorTodo_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));    
    newRow.append($("<td><input style='width:110px' type='text' id='totalIncluidoOtrosPrecios_" + rowCount + "' class='inputPersonalizado campoFormulario' disabled></td>"));

    // Agregar las nuevas celdas
    newRow.append($("<td><input style='width:110px' type='hidden' id='manoObraCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='porcentajeAdminCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='porcentajeUtilidadCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='alquilerEquiposCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='transporteCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='elementosProteccionCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));
    newRow.append($("<td><input style='width:110px' type='hidden' id='dotacionCalcular_" + rowCount + "' class='inputPersonalizado campoFormulario' onchange='tuFuncion(this);' disabled></td>"));

    newRow.append("<td><button type='button' class='btn btn-danger btn-sm delete-row-button' onclick='eliminarFila(this)'>-</button></td>");
    
    // Agregar la nueva fila a la tabla
    $("#dynamic-table tbody").append(newRow);
    
    // Incrementar el contador de filas
    rowCount++;
    $("#rowCount").val(rowCount);
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

function sumarPrecioTotal() {
    var precioTotal = 0;
    var totalIva = 0;
    var totalRetefuente = 0;
    var totalPorTodo = 0;
    var manoObra = 0;
    var elementosProteccion = 0;
    var totalValoresIncluidos = 0;
    precioTotal += eliminarPuntosYConvertirAFloat($("#precioTotal").val()) || 0; // Tratar el caso especial
    totalIva += eliminarPuntosYConvertirAFloat($("#totalIva").val()) || 0; // Tratar el caso especial
    totalRetefuente += eliminarPuntosYConvertirAFloat($("#totalRetefuente").val()) || 0; // Tratar el caso especial
    totalPorTodo += eliminarPuntosYConvertirAFloat($("#totalPorTodo").val()) || 0; // Tratar el caso especial
    manoObra += eliminarPuntosYConvertirAFloat($("#manoObra").val()) || 0; // Tratar el caso especial
    elementosProteccion += eliminarPuntosYConvertirAFloat($("#elementosProteccion").val()) || 0; // Tratar el caso especial
    totalValoresIncluidos += eliminarPuntosYConvertirAFloat($("#totalIncluidoOtrosPrecios").val()) || 0; // Tratar el caso especial

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

    $("#totalNeto").text(precioTotal.toLocaleString('es-CO'));
    $("#totalNetoInput").val(precioTotal.toLocaleString('es-CO'));

    $("#totalIVA").text(totalIva.toLocaleString('es-CO'));
    $("#totalIVAInput").val(totalIva.toLocaleString('es-CO'));

    $("#totalRetefuenteTabla").text(totalRetefuente.toLocaleString('es-CO'));
    $("#totalRetefuenteTablaInput").val(totalRetefuente.toLocaleString('es-CO'));

    $("#totalPorTodoTabla").text(totalPorTodo.toLocaleString('es-CO'));
    $("#totalPorTodoTablaInput").val(totalPorTodo.toLocaleString('es-CO'));

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

function calcularCamposAdicionales() {
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
            $("#totalIncluidoOtrosPrecios").val(totalTabla);
            formatoPesoColombiano($("#totalIncluidoOtrosPrecios"));
        } else {
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
    cargarCotizaciones();
}

function cargarInfoCotizaciones(){
    let campo = $('#cotizacionSelect');
    var selectedCotizacion = $(campo).val();
    if(selectedCotizacion !== "") {
        obtenerInfoCotizacion(selectedCotizacion);
    } else {
        $("#infoCotizacion").empty();
    }
}

function cargarCotizaciones() {
    // Realizar la solicitud para obtener las opciones del select
    let data = {};
    data["accion"] = "S-CotizacionesContabilidad";
    $.ajax({
        url: "search.php", // Archivo PHP que maneja la consulta a la base de datos
        method: "POST",
        data: data,
        success: function(data) {
            // Agregar las opciones al select
            $("#cotizacionSelect").html(data);
        }
    });
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
let valorPorcentaje1Original = 0;
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
        <button onclick="openModal(\'modalP1\')" class="btn btn-primary btn-sm" ' + (botonModalPago1 ? 'disabled' : '') + '>Abrir Modal</button>\
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
                                        <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante1\');">\
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
        <button onclick="openModal(\'modalP2\')" class="btn btn-primary btn-sm" ' + (botonModalPago2 ? 'disabled' : '') + '>Abrir Modal</button>\
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
                    <button class="btn btn-primary" onclick="campoAgregarFila(\'#tablaPorcentaje1\')">+</button>\
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
                                            <input type="text" class="form-control campoFormulario obligatorio" id="precio" onchange="formatoPesoColombiano(this); calcularGastosContabilidad(this, \'totalRestante2\');">\
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
        <td colspan="10" id="totalRestante3"></td>\
    </tr>\
    </tbody>\
  </table>\<table class="table table-responsive tablaContabilidadContrato">\
  <thead>\
    <tr>\
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
      <td colspan="10" id="totalRestante4"></td>\
    </tr>\
  </tbody>\
</table>';
    let arrayValoresAdicionales = [manoObra, porcentajeAdmin, porcentajeUtilidad, alquilerEquipos, transporte, elementosProteccion, Dotacion]
    $("#infoCotizacion").html(html);
    discriminarPorPrecios(valorPago1, arrayValoresAdicionales, 1);
    discriminarPorPrecios(valorPago2, arrayValoresAdicionales, 2);
    discriminarPorPrecios(valorPago3, arrayValoresAdicionales, 3);
    discriminarPorPrecios(valorPago4, arrayValoresAdicionales, 4);
    let valorTotalPorcentaje1 = $('#totalRestante1').text().match(/\d+(\.\d+)?/);
    valorPorcentaje1Original = valorTotalPorcentaje1 ? valorTotalPorcentaje1[0] : null;
}
function openModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = 'block';
}

function closeModal(idModal) {
    var modal = document.getElementById(idModal);
    modal.style.display = 'none';
}

function calcularGastosContabilidad(campo, totalAntesDe) {
    let valorTotalAntesDe = $('#' + totalAntesDe).text();
    let soloNumeros = valorTotalAntesDe.match(/\d+(\.\d+)?/);
    let numeroExtraido = soloNumeros ? soloNumeros[0] : null;
    numeroExtraido = eliminarPuntosYConvertirAFloat(numeroExtraido);

    // Obtener el valor del campo de la fila eliminada
    let valorCampo = eliminarPuntosYConvertirAFloat($(campo).val());

    // Establecer valorCampo en 0 si el primer campo que incluye la palabra "precio" está vacío
    valorCampo = isNaN(valorCampo) ? 0 : valorCampo;

    let tabla = $(campo).closest('table');
    if (tabla.find('tbody tr').length === 1 && valorCampo === 0) {
        // Restaurar al valor anterior
        $('#' + totalAntesDe).html('<h3>Total restante:</h3>' + formatoPesoColombianoReturn(valorPorcentaje1Original));
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

function calcularPorcentaje(valor, porcentaje) {
    if(porcentaje === "" || porcentaje === undefined){
        return 0;
    }
    // Eliminar el símbolo "%" y convertir a entero
    if(porcentaje.includes('%')){
        porcentaje = parseInt(porcentaje.replace('%', '').trim(), 10);
        // Calcular el porcentaje del valor
        return (valor * porcentaje) / 100;
    }else{
        return eliminarPuntosYConvertirAFloat(porcentaje);
    }
    
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
        let valorPago1 = $('valorPago1', xml).text();
        let valorPago2 = $('valorPago2', xml).text();
        let valorPago3 = $('valorPago3', xml).text();
        let valorPago4 = $('valorPago4', xml).text();    
        $('#valorPago1').val(valorPago1);
        $('#valorPago2').val(valorPago2);
        $('#valorPago3').val(valorPago3);
        $('#valorPago4').val(valorPago4);
        if(!vacio(valorPago1) || !vacio(valorPago2) || !vacio(valorPago3) || !vacio(valorPago4)){
            $('#guardarPagosCotizacion').attr('onclick', 'editarPagoContrato()');
            calcularTotalRestarContrato($('valorTotalCotizacion', xml).text(), valorPago1, valorPago2, valorPago3, valorPago4);
        }
        $('#valorTotalCotizacion').text($('valorTotalCotizacion', xml).text());
        $('#pagoValorContrato').show();
    }
}

function calcularTotalRestarContrato(totalContrato, valor1, valor2, valor3, valor4){
    totalContrato = eliminarPuntosYConvertirAFloat(totalContrato);
    valor1 = eliminarPuntosYConvertirAFloat(valor1);
    valor2 = eliminarPuntosYConvertirAFloat(valor2);
    valor3 = eliminarPuntosYConvertirAFloat(valor3);
    valor4 = eliminarPuntosYConvertirAFloat(valor4);
    let resta = totalContrato - valor1 - valor2 - valor3 - valor4;
    $('#valorRestante').text(formatoPesoColombianoReturn(resta));
}

function editarPagoContrato(){
    let cotizacionId = $('#documentoId').val();
    let valorPago1 = $('#valorPago1').val();
    let valorPago2 = $('#valorPago2').val();
    let valorPago3 = $('#valorPago3').val();
    let valorPago4 = $('#valorPago4').val();
    let param = '<cotizacionId>'+cotizacionId+'</cotizacionId>';
    param = param + '<valorPago1>'+valorPago1+'</valorPago1>';
    param = param + '<valorPago2>'+valorPago2+'</valorPago2>';
    param = param + '<valorPago3>'+valorPago3+'</valorPago3>';
    param = param + '<valorPago4>'+valorPago4+'</valorPago4>';
    sendXML(1, 'U-pagoContrato', param, editarPagoContratoAnswer);
}

function editarPagoContratoAnswer(xml){
    if($('respuesta',xml).text() === "OK"){
        mostrarAlertas(['Se ha actualizado el pago del contrato correctamente'], 'success');
    }
}