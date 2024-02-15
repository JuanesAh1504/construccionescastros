let deleteFila = false;

function campoAgregarFila(tablaOrigen, cantidad = 1) {
    let rowCount = parseInt($("#rowCountModal").val()) || 0;
    rowCount += cantidad;
    $('#rowCountModal').val(rowCount);

    let table = tablaOrigen;
    let filaClonar = $(table + ' tbody tr:first').clone();
    $(filaClonar).find('input[type="text"]').val('');
    let numFilas = $(table + ' tbody tr').length;

    // Clonar la fila según la cantidad especificada
    for (let i = 0; i < cantidad; i++) {
        let filaClonada = filaClonar.clone();
        $(table + ' tbody').append(filaClonada);

        // Modificar los atributos de ID de los elementos clonados
        filaClonada.find('#producto, #precio').each(function () {
            let originalId = $(this).attr('id');
            $(this).attr('id', originalId + '_' + (numFilas + i)); // Incrementar el número de fila
        });

        // Crear el botón de eliminación y agregarlo a la fila clonada
        let botonEliminar = $('<button type="button" class="btn btn-danger btn-smbtnEliminarFila">-</button>');
        botonEliminar.click(function() {
            let inputPrecio = $(this).closest('tr').find('input[id*="precio"]');
            deleteFila = true;
            calcularGastosContabilidad(inputPrecio, 'totalRestante1');
            $(this).closest('tr').remove(); // Eliminar la fila al hacer clic en el botón
            updateRowCount(table); // Actualizar el contador después de eliminar la fila
        });
        filaClonada.append($('<td>').append(botonEliminar));
    }
}


function updateRowCount(table) {
    let rowCount = $(table + ' tbody tr').length;
    $('#rowCountModal').val(rowCount);
}

function updateRowCountTabla(table) {
    let rowCount = $(table + ' tbody tr:not(.addNuevaFila)').length;
    $('#rowCount').val(rowCount);
}

function vacio(variable){
    if (variable === null || variable === undefined || variable === '') {
        return true; // Devolver true si se encuentra un valor vacío, nulo o indefinido
    }
    return false;
}

function activarCampos(checkbox, numeral) {
    let campoValorPagado = $(checkbox).closest('div').parent().find('#valorPago' + numeral);
    let campoFechaPagado = $(checkbox).closest('div').parent().find('#fechaPagado' + numeral);

    // Verificar si el checkbox está marcado
    if ($(checkbox).prop('checked')) {
        // Si está marcado, deshabilitar los campos
        $(campoValorPagado).prop('disabled', false);
        $(campoFechaPagado).prop('disabled', false);
    } else {
        // Si no está marcado, habilitar los campos
        $(campoValorPagado).prop('disabled', true);
        $(campoFechaPagado).prop('disabled', true);
    }
}

function duplicarFilas(tablaOrigen, cantidad = 1) {
    let rowCount = parseInt($("#rowCount").val()) || 0;
    rowCount += cantidad;
    $('#rowCount').val(rowCount);

    let tabla = $(tablaOrigen);
    let filaClonar = tabla.find('tbody tr:first').clone();
    filaClonar.find('input[type="text"]').val('');
    let numFilas = tabla.find('tbody tr').length;

    // Clonar la fila según la cantidad especificada
    for (let i = 0; i < cantidad; i++) {
        let filaClonada = filaClonar.clone();
        tabla.find('tbody').append(filaClonada);

        // Modificar los atributos de ID y onchange de los elementos clonados
        filaClonada.find('[id]').each(function () {
            let originalId = $(this).attr('id');
            $(this).attr('id', originalId + '_' + (numFilas - 1)); // Incrementar el número de fila
            let onchangeAttr = $(this).attr('onchange');
            if (onchangeAttr) {
                $(this).attr('onchange', onchangeAttr.replace(originalId, originalId + '_' + (numFilas - 1)));
            }
        });

        // Añadir botón de eliminación
        let botonEliminar = $('<button type="button" class="btn btn-danger btn-sm btnEliminarFila">-</button>');
        botonEliminar.click(function() {
            $(this).closest('tr').remove(); // Eliminar la fila al hacer clic en el botón
            updateRowCountTabla(tablaOrigen); // Actualizar el contador después de eliminar la fila
            cuentaCobroTotal();
        });
        filaClonada.append($('<td>').append(botonEliminar));
    }
}

function cuentaCobroTotal(){
    let total = 0;
    $('#conceptosCuentaCobro tbody input[id^="precioTotal"]').each(function() {
        let valor = eliminarPuntosYConvertirAFloat($(this).val()) || 0;
        total += valor;
    });
    $('#totalCuentaCobro').text(formatoPesoColombianoReturn(total)); // Mostrar el total en el footer
    $('#totalCuentaCobroInput').val(formatoPesoColombianoReturn(total)); // Mostrar el total en el footer
}