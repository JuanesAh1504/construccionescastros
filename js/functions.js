document.write('<script src="js/jquery-3.7.1.min.js"></script>');

function agregarFila() {
    var rowCount = parseInt($("#rowCount").val());
    var newRow = $("<tr>");
    newRow.append("<td><input type='text' class='form-control campoFormulario' id='materiales_" + rowCount + "'></td>");
    newRow.append("<td><input type='text' class='form-control campoFormulario' id='metrosUnidades_" + rowCount + "'></td>");
    newRow.append("<td><input type='text' class='form-control campoFormulario' id='precioUnitario_" + rowCount + "' onchange='formatoPesoColombiano(this);calcularFormula(\"cantidad_" + rowCount + "\", \"precioUnitario_" + rowCount + "\", \"precioTotal_" + rowCount + "\")'></td>");
    newRow.append("<td><input type='text' class='form-control campoFormulario' id='cantidad_" + rowCount + "' value='1' onchange='calcularFormula(\"precioUnitario_" + rowCount + "\", \"cantidad_" + rowCount + "\", \"precioTotal_" + rowCount + "\")'></td>");
    newRow.append("<td><input type='text' class='form-control campoFormulario' id='precioTotal_" + rowCount + "'></td>");
    newRow.append("<td><button type='button' class='btn btn-danger btn-sm delete-row-button' onclick='eliminarFila(this)'>-</button></td>");
    $("#dynamic-table tbody").append(newRow);
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
}

function generarNumeroAleatorio() {
    const numeroAleatorio = Math.floor(10000 + Math.random() * 90000);
    const inputNumero = document.getElementById("documentoId");
    inputNumero.value = numeroAleatorio;
}

function formatoPesoColombiano(campo){
    let valor = $(campo).val();
    valor = valor.replace(/,/g, '');
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $(campo).val(valor);
}

function eliminarPuntosYConvertirAFloat(valor) {
    return parseFloat(valor.replace(/\./g, '').replace(',', '.'));
}

function calcularFormula(campoACalcularId, campoActualId, campoDestinoId){
    let campoACalcularValor = eliminarPuntosYConvertirAFloat($('#' + campoACalcularId).val()) || 0;
    let campoActualValor = eliminarPuntosYConvertirAFloat($('#' + campoActualId).val()) || 0;
    const valorTotal = (campoACalcularValor * campoActualValor);
    $("#" + campoDestinoId).val(valorTotal);
    formatoPesoColombiano($("#" + campoDestinoId));
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