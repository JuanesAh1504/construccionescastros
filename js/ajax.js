function sendXML(archivo, accion, param, funcionRespuesta){
    if(archivo === 1){
        archivo = "accion.php";
    }else if(archivo === 2){
        archivo = "search.php";
    }
    var xmlString = "<xml><accion>"+accion+"</accion><param>"+param+"</param></xml>";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", archivo, true);
    xmlhttp.setRequestHeader("Content-Type", "application/xml");
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                // Manejar la respuesta del servidor
                var responseXml = xmlhttp.responseXML;
                if (typeof funcionRespuesta === "function") {
                    funcionRespuesta(responseXml);
                }
            } else {
                // Manejar errores si es necesario
                console.error("Error en la solicitud al servidor");
            }
        }
    };
    xmlhttp.send(xmlString);
}