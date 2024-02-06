function validarFormulario(idFormulario, accion) {
  var campos = document.querySelectorAll(".campoFormulario");
  var errores = [];
  for (var i = 0; i < campos.length; i++) {
    var campo = campos[i];
    var valor = campo.value.trim();
    var label = obtenerTextoLabel(campo); // Obtener el texto del label
    if (valor === "" && $(campos[i]).attr('class').includes('obligatorio')) {
      errores.push('El campo "' + label + '" no puede estar vacío.');
      continue;
    }
    // Validar campos de tipo "number"
    if (campo.type === "number" || campo.className.includes("campoNumero")) {
      if (!validarNumero(valor)) {
        errores.push('El campo "' + label + '" debe contener solo caracteres numéricos.');
      }
    }
    if (campo.type === "select") {
      if (!validarSelect(valor)) {
        errores.push('Se debe seleccionar una opción para el campo ' + label + '.');
      }
    }
  }
  if (errores.length > 0) {
    mostrarAlertas(errores, "danger");
    return false; // Evitar que el formulario se envíe si hay errores
  }
  if(idFormulario !== "formLoginInicial"){
    enviarInformacion(idFormulario, accion);
    return;
  }
  enviarDatosLogin(idFormulario);
}

let huboError = false;
function validarCampos(){
    huboError = false;
    let div = $('.formulario');
    let campos = $('.obligatorio', div);   
    for (let i = 0; i < campos.length; i++) {
        let inputCampo =  $(campos[i]).find('input, textarea, select');
        let valorCampo = $(inputCampo).val();
        let etiquetaCampo = $(inputCampo).closest('.obligatorio').find('label').text();

        if (valorCampo == "") {
            showAlerta("El campo <strong>" + etiquetaCampo + "</strong> está vacío.", 1);
            huboError = true;
        }
    }
    return huboError;
}

function showAlerta(mensaje, tipo){
  let color;
  let colorLetra;
    if (tipo == "1") {
        color = "#f00"; //error
    } else if (tipo == "2") {
        color = "#00a616"; //success
    } else if (tipo == "3") {
        color = "#fbff00"; //warning
        colorLetra = "#000";
    }
    let errorElement = $('<div class="mensaje-error"></div>').html(mensaje);
    $(errorElement).css('background-color', color);
    $(errorElement).css('color', colorLetra);
    $('#errores-container').prepend(errorElement);
    $('#errores-container').css('display', 'block');
    errorElement.hide().appendTo('#errores-container').fadeIn();
    let anchoTexto = $(errorElement).width();
    errorElement.width(anchoTexto);
    setTimeout(function () {
        errorElement.fadeOut(function () {
            $(this).remove();
        });
    }, 9000);
}

function mostrarAlertas(alertas, tipoAlerta) {
    var errorContainer = document.getElementById("error-container");
    errorContainer.innerHTML = '';
  
    for (var i = 0; i < alertas.length; i++) {
      var errorDiv = document.createElement("div");
      errorDiv.textContent = alertas[i];
      
      // Aplicar el estilo de acuerdo al tipo de alerta
      if (tipoAlerta === "success") {
        errorDiv.className = "success-message"; // Clase para mensajes de éxito
      } else if (tipoAlerta === "danger") {
          errorDiv.className = "error-message"; // Clase para mensajes de error
      }
  
      errorContainer.appendChild(errorDiv);
    }
    errorContainer.style.display = "flex";

  // Aplicar la animación de entrada
  setTimeout(function () {
    errorContainer.style.transition = "opacity 0.5s";
    errorContainer.style.opacity = "1";
  }, 10);

  // Temporizador para ocultar las alertas después de 6 segundos (6000 milisegundos)
  setTimeout(function () {
    errorContainer.style.opacity = "0"; // Ocultar con animación de opacidad
    setTimeout(function () {
      errorContainer.style.display = "none";
    }, 500); // Esperar a que termine la animación
  }, 6000);
}

function obtenerTextoLabel(campo) {
  var label = $(campo).closest('div.campo').find('label').text().trim();
  // Eliminar el asterisco (*) si está presente en el texto del label
  label = label.replace('*', '').trim();
  if (label) {
    return label;
  }
  return $(campo).attr('name');
}

function validarNumero(valor){
  var regex = /^[0-9]+$/;
    return regex.test(valor);
}

function validarSelect(campo) {
  if (campo.value === "") {
      return false; 
  }
  return true; 
}

function validarFecha(fecha) {
  // Expresión regular para validar el formato "dd/mm/aaaa"
  var formatoFecha = /^\d{2}\/\d{2}\/\d{4}$/;

  if (!formatoFecha.test(fecha)) {
    // El formato de la fecha no es válido
    return false;
  }

  // Separar el día, mes y año
  var partesFecha = fecha.split('/');
  var dia = parseInt(partesFecha[0], 10);
  var mes = parseInt(partesFecha[1], 10) - 1; // Los meses en JavaScript van de 0 a 11
  var año = parseInt(partesFecha[2], 10);

  // Validar si el día, mes y año son completos
  if (isNaN(dia) || isNaN(mes) || isNaN(año)) {
    return false;
  }

  // Crear un objeto Date y verificar si es una fecha válida
  var fechaValida = new Date(año, mes, dia);

  return (
    fechaValida.getDate() === dia &&
    fechaValida.getMonth() === mes &&
    fechaValida.getFullYear() === año
  );
}
