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
