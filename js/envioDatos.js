document.write('<script src="js/jquery-3.7.1.min.js"></script>');
function enviarDatosLogin(idFormulario, classButton) {
    let formulario = $("#" + idFormulario); // Referencia al formulario actual
    let respuesta = $(".respuesta");
    
    // Crear un objeto 'data' para almacenar los valores de los campos
    let data = {};
    
    // Recorrer los campos con la clase 'campoFormulario' y agregar sus valores a 'data'
    formulario.find('.campoFormulario').each(function() {
        let campo = $(this);
        data[campo.attr('id')] = campo.val();
    });
    data["case"] = "Login";
    
    $.ajax({
        url: "validarDatos.php", // Archivo PHP que maneja la inserción en la base de datos
        method: "POST",
        data: data, // Enviar el objeto 'data' con los valores de los campos
        success: function(response) {
            try {
                const jsonResponse = JSON.parse(response); // Intenta analizar la respuesta como JSON
                if (jsonResponse.success === true) {
                    mostrarAlertas([jsonResponse.message], "success");
                    setTimeout(() => window.location.href = "panel.php", 2000);
                } else if (jsonResponse.danger === true) {
                    mostrarAlertas([jsonResponse.message], "danger");
                } 
            } catch (e) {

            }
        },
        error: function(xhr, status, error) {
            // Manejar errores en la solicitud AJAX
        }
    });
}

function enviarInformacion(idFormulario, accion) {
    let formulario = $("#" + idFormulario);
    let respuesta = $(".respuesta");
    let data = {};

    formulario.find('.campoFormulario').each(function() {
        let campo = $(this);
        data[campo.attr('id')] = campo.val();
    });
    data["documentoId"] = $("#documentoId").val();
    data["accion"] = accion;
    $.ajax({
        url: "action.php", // Archivo PHP que maneja la inserción en la base de datos
        method: "POST",
        data: data, // Enviar el objeto 'data' con los valores de los campos
        success: function(response) {
            try {
                const jsonResponse = JSON.parse(response); // Intenta analizar la respuesta como JSON
                if (jsonResponse.success === true) {
                    mostrarAlertas([jsonResponse.message], "success");
                } else if (jsonResponse.danger === true) {
                    mostrarAlertas([jsonResponse.message], "danger");
                } 
            } catch (e) {

            }
        },
        error: function(xhr, status, error) {
            // Manejar errores en la solicitud AJAX
        }
    });
}

function guardarGastos(idTabla, idTotal) {
    let tabla = $(idTabla);
    let data = {};
    let valorTotal = $(idTotal).text();
    let soloNumeros = valorTotal.match(/\d+(\.\d+)?/);
    let numeroExtraido = soloNumeros ? soloNumeros[0] : null;
    numeroExtraido = formatoPesoColombianoReturn(eliminarPuntosYConvertirAFloat(numeroExtraido));
    let camposTabla = $(tabla).find('.campoFormulario');
    let param = '';
    for (var i = 0; i < camposTabla.length; i++) {
        var campo = $(camposTabla[i]);
        var idCampo = campo.attr("id");
        var valorCampo = campo.val();
        if(idCampo !== 'rowCountModal' && idCampo !== 'porcentaje' && idCampo !== 'numeralPorcentaje' && idCampo !== 'idContrato'){
            param += '<idCampo>' + idCampo + '</idCampo>';
            param += '<valor>' + valorCampo + '</valor>';
        }
    }
    param += '<totalRestante>'+numeroExtraido+'</totalRestante>';
    param += '<rowCountModal>'+$('#rowCountModal', tabla).val()+'</rowCountModal>';
    param += '<porcentaje>'+$('#porcentaje', tabla).val()+'</porcentaje>';
    param += '<numeralPorcentaje>'+$('#numeralPorcentaje', tabla).val()+'</numeralPorcentaje>';
    param += '<idContrato>'+$('#idContrato', tabla).val()+'</idContrato>';
    param += '<tdTotal>'+idTotal+'</tdTotal>';
    data["accion"] = 'SaveGastos';
    sendXML(1, 'I-Gastos', param, guardarGastosAnswer);
}

function guardarGastosAnswer(xml){
    if($('respuesta',xml).text() === "OK"){
        showAlerta('Los gastos se guardaron correctamente.', 2);
    }else if($('respuesta',xml).text() === "REPETIDOS"){
        showAlerta('Hay gastos repetidos, se guardaron los cambios nuevos.', 3);
    }else if($('respuesta',xml).text() === "ERROR"){
        showAlerta('Ocurrió un error al guardar los datos.', 1);
    }
}

function editarGastos(idTabla, idTotal){
    let tabla = $(idTabla);
    let data = {};
    let valorTotal = $(idTotal).text();
    let soloNumeros = valorTotal.match(/\d+(\.\d+)?/);
    let numeroExtraido = soloNumeros ? soloNumeros[0] : null;
    numeroExtraido = formatoPesoColombianoReturn(eliminarPuntosYConvertirAFloat(numeroExtraido));
    let camposTabla = $(tabla).find('.campoFormulario');
    let param = '';
    for (var i = 0; i < camposTabla.length; i++) {
        var campo = $(camposTabla[i]);
        var idCampo = campo.attr("id");
        var valorCampo = campo.val();
        if(idCampo !== 'rowCountModal' && idCampo !== 'porcentaje' && idCampo !== 'numeralPorcentaje' && idCampo !== 'idContrato'){
            param += '<idCampo>' + idCampo + '</idCampo>';
            param += '<valor>' + valorCampo + '</valor>';
        }
    }
    param += '<totalRestante>'+numeroExtraido+'</totalRestante>';
    param += '<rowCountModal>'+$('#rowCountModal', tabla).val()+'</rowCountModal>';
    param += '<porcentaje>'+$('#porcentaje', tabla).val()+'</porcentaje>';
    param += '<numeralPorcentaje>'+$('#numeralPorcentaje', tabla).val()+'</numeralPorcentaje>';
    param += '<idContrato>'+$('#idContrato', tabla).val()+'</idContrato>';
    param += '<tdTotal>'+idTotal+'</tdTotal>';
    sendXML(1, 'U-gastos', param,editarGastosAnswer);
}

function editarGastosAnswer(xml){
    
}