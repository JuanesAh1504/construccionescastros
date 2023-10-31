function validarFormulario(idFormulario, accion) {
  var campos = document.querySelectorAll(".campoFormulario");
  var errores = [];

  for (var i = 0; i < campos.length; i++) {
    var campo = campos[i];
    var valor = campo.value.trim();
    var label = obtenerTextoLabel(campo); // Obtener el texto del label

    if (valor === "") {
      errores.push('El campo "' + label + '" no puede estar vacío.');
      continue;
    }

    // Validar campos de tipo "number"
    if (campo.type === "number" || campo.className.includes("campoNumero")) {
      if (!validarNumero(valor)) {
        errores.push('El campo "' + label + '" debe contener solo caracteres numéricos.');
      }
    }

     // Validar campos de tipo "date"
    if (campo.type === "date") {
      if (!validarFecha(valor)) {
        errores.push('El campo "' + label + '" debe contener una fecha válida en el formato yyyy-mm-dd.');
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
