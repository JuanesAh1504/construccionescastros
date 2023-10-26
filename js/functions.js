document.write('<script src="js/jquery-3.7.1.min.js"></script>');

function agregarFila() {
    var materialesContainer = $("#materiales-container");
    var newInput = $("<div class='input-group mb-3'>" +
        "<input type='text' class='form-control' name='material[]'>" +
        "<div class='input-group-append'>" +
        "<button class='btn btn-outline-danger eliminar-material' type='button'>-</button>" +
        "</div>" +
        "</div>");

    materialesContainer.append(newInput);

    $(".eliminar-material").click(function() {
        $(this).closest(".input-group").remove();
    });
}