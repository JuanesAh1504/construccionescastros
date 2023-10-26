const aside = document.getElementById("contenidoPagina"),
    menuContenido = document.getElementById("menuContenido");

menuContenido.onclick = () => { aside.classList.toggle('active'); }

function loadContent(file) {
    const contentContainer = document.getElementById("workspace");
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            contentContainer.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", file, true);
    xhttp.send();
}