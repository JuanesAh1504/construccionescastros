document.write('<script src="js/jquery-3.7.1.min.js"></script>');

const aside = document.getElementById("contenidoPagina"),
    menuContenido = document.getElementById("menuContenido");

menuContenido.onclick = () => { aside.classList.toggle('active'); }

function loadContent(file, documento = '') {
    event.preventDefault();
    const contentContainer = document.getElementById("workspace");
    const xhttp = new XMLHttpRequest();
    // Variable de bandera para controlar si el contenido ya ha sido cargado
    let contenidoCargado = false;
    xhttp.onreadystatechange = function () {
        if (!contenidoCargado && this.readyState === 4 && this.status === 200) {
            contentContainer.innerHTML = this.responseText;
            if (!file.includes("listar")) {
                generarNumeroAleatorio();
            }
            // Actualiza la variable de bandera
            contenidoCargado = true;
        }
    };
    xhttp.open("GET", file, true);
    xhttp.send();
}

function listarDocumentos(documento){
    event.preventDefault();
    loadContent(documento);
    if(documento.includes("listar")){
        document.getElementById("activarFuncionCargarListado").click();
    }
}