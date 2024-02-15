function guardar(tipo, subtipo){
    let div = $('.formulario');
    let campos = $('.campo', div);
    let param = '';
    validarCampos();
    if(!huboError){
        for (var i = 0; i < campos.length; i++) {
            let inputCampo = $(campos[i]).find('input, textarea, select');
            if(inputCampo.length > 1) {
                // Si hay varios elementos, iterar sobre cada uno
                inputCampo.each(function(index, element) {
                    let idCampo = $(element).attr('id');
                    let valorCampo = $(element).val();
                    param = param + "<idCampo>" + idCampo + "</idCampo><valor>" + valorCampo + "</valor>";
                });
            } else {
                // Si solo hay un elemento, obtener su valor directamente
                let idCampo = $(inputCampo).attr('id');
                let valorCampo = $(inputCampo).val();
                param = param + "<idCampo>" + idCampo + "</idCampo><valor>" + valorCampo + "</valor>";
            }
        }
        if(tipo == 1){
            sendXML(1, 'I-'+subtipo, param, guardarAnswer);
        } else if(tipo == 2){
            sendXML(1, 'U-'+subtipo, param, guardarAnswer);
        }
    }
}

function guardarAnswer(xml) {
    if ($('respuesta', xml).text() == "OK") {
        showAlerta(''+$('documento', xml).text()+' ha sido guardado correctamente', 2);
        
        // Buscar el botón con el evento onclick que llama a guardar()
        let botonGuardar = $('button[onclick*="guardar("]');
        
        // Verificar si se encontró el botón
        if (botonGuardar.length > 0) {
            // Obtener el valor actual del evento onclick
            let onclickValue = botonGuardar.attr('onclick');
            
            // Utilizar una expresión regular para reemplazar el primer parámetro de guardar()
            let nuevoOnclickValue = onclickValue.replace(/guardar\(\d+/, 'guardar(2');
            
            // Modificar el evento onclick con el nuevo valor
            botonGuardar.attr('onclick', nuevoOnclickValue);
        }
        if($('documento', xml).text() == "Cuenta de cobro"){
            let idCuentaCobroValue = $('idCuentaCobro', xml).text();
            // Crear el input para idCuentaCobro dentro de su propio div
            let divIdCuentaCobro = $('<div>').addClass('campo');
            let inputIdCuentaCobro = $('<input>').attr({
                type: 'hidden',
                id: 'idCuentaCobro',
                value: idCuentaCobroValue
            });
            divIdCuentaCobro.append(inputIdCuentaCobro);

            // Obtener el valor de consecutivo_cliente del XML
            let consecutivoClienteValue = $('consecutivo', xml).text();
            
            // Crear el input para consecutivo_cliente dentro de su propio div
            let divConsecutivoCliente = $('<div>').addClass('campo');
            let inputConsecutivoCliente = $('<input>').attr({
                type: 'hidden',
                id: 'consecutivo',
                value: consecutivoClienteValue
            });
            divConsecutivoCliente.append(inputConsecutivoCliente);

            // Agregar los divs al formulario
            $('div.formulario').prepend(divIdCuentaCobro, divConsecutivoCliente);
        }
    } else {
        showAlerta('Hubo un error al guardar '+$('documento', xml).text()+'', 1);
    }
}

