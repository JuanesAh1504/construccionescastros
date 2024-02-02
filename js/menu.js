document.write('<script src="js/jquery-3.7.1.min.js"></script>');

const aside = document.getElementById("contenidoPagina"),
    menuContenido = document.getElementById("menuContenido");

menuContenido.onclick = () => { aside.classList.toggle('active'); }

function loadContent(file) {
    const contenedor = $("#workspace");
    // Limpiar el contenido anterior
    contenedor.empty();
    // Cargar el nuevo contenido
    if (!file.includes("listar")) {
        // Lógica adicional si no es un archivo de tipo "listar"
        generarNumeroAleatorio();
    }
    // Cargar el contenido del archivo en el contenedor
    contenedor.load(file);
}

function listarDocumentos(documento) {
    event.preventDefault();
    loadContent(documento);
    if (documento.includes("listar")) {
        setTimeout(function() {
            $("#activarFuncionCargarListado").click();
            setTimeout(function() {
                if (!$(".listar").children().find("table").is(":visible")) {
                    $("#activarFuncionCargarListado").click();
                }
            }, 800);
        }, 700);
    }
}
