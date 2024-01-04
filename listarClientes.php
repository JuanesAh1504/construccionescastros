<!DOCTYPE html>
<html lang="en">
    <body> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <div class="contenedor">
            <br>
            <h4 style="color: #00535E;font-weight:bold">Listado - Documento Clientes</h4>
            <p>Visualice los Clientes creados. </p>
            <div style="display:none">
                <button id="activarFuncionCargarListado" onclick="peticionListado('L-clientes')"></button>
            </div>
            <!-- Tabla de listado -->
            <div id="tablaListado"></div>
        </div>
    </body>
</html>