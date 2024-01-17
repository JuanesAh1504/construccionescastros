function guardar(tipo){
    let div = $('.formulario');
    let campos = $('.campo', div);
    let param = '';
    validarCampos();
    if(!huboError){
        for (var i = 0; i < campos.length; i++) {
            let inputCampo = $(campos[i]).find('input, textarea, select');
            let idCampo = $(inputCampo).attr('id');
            let valorCampo = $(inputCampo).val();
            param = param + "<idCampo>" + idCampo + "</idCampo><valor>" + valorCampo + "</valor>";
        }
        if(tipo == 1){
            sendXML(1, 'I-user', param, guardarAnswer);
        }else if(tipo == 2){
            sendXML(1, 'U-user', param, guardarAnswer);
        }
    }
}

function guardarAnswer(xml){
    if($('response', xml).text() == "OK"){
        showAlerta('El cliente ha sido creado correctamente', 2);
    }else{
        showAlerta('Hubo un error al guardar el cliente.', 1);
    }
}