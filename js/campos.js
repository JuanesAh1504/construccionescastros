let deleteFila = false;

function campoAgregarFila(tablaOrigen) {
    let rowCount = parseInt($("#rowCountModal").val()) || 0;
    rowCount++;
    $('#rowCountModal').val(rowCount);

    let table = tablaOrigen;
    let filaClonar = $(table + ' tbody tr:first').clone();
    $(filaClonar).find('input[type="text"]').val('');
    let numFilas = $(table + ' tbody tr').length;

    // Modificar los atributos de ID de los elementos clonados
    filaClonar.find('#producto, #precio').each(function () {
        let originalId = $(this).attr('id');
        $(this).attr('id', originalId + '_' + numFilas);
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
    filaClonar.append($('<td>').append(botonEliminar));

    // Agregar el clon al final de la tabla de origen
    $(table + ' tbody').append(filaClonar);
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