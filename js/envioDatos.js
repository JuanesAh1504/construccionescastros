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