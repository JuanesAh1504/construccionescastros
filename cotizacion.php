<body onload="generarNumeroAleatorio()">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="contenedor">
        <form id="formCotizacion" autocomplete="off">
            <br>
            <h4 style="color: #00535E;font-weight:bold">Ingrese los datos de Cotización</h4>
            <p>Crea cotizaciones de todos tus productos o servicios y lleva un mejor control.</p>
            <div class="card">
                <div class="card-header bg-primary text-white" style="font-weight:bold">
                    Información general
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" id="documentoId" name="documentoId" value="">
                    <input type="hidden" class="campoFormulario" value="1" id="rowCount">
                    <div class="row">
                        <div class="form-group col-6 campo">
                            <label for="organizacionEmpresas">Cliente</label>
                            <input type="text" class="form-control campoFormulario" id="organizacionEmpresas">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 campo">
                            <table id="dynamic-table">
                                <thead>
                                    <tr>
                                        <td>Materiales</td>
                                        <td>M<sub>2</sub> - Unidades M Lineal</td>
                                        <td>Precio unitario</td>
                                        <td>Cantidad</td>
                                        <td>Precio total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td style="width:380px"><input type="text" class="form-control campoFormulario" id="materiales"></td>
                                    <td><input type="text" class="form-control campoFormulario" id="metrosUnidades"></td>
                                    <td style="width:140px"><input type="text" class="form-control campoFormulario" id="precioUnitario" onchange="formatoPesoColombiano(this);calcularFormula('cantidad', 'precioUnitario', 'precioTotal')"></td>
                                    <td style="width:80px"><input type="text" class="form-control campoFormulario campoNumero" id="cantidad" value="1" onchange="calcularFormula('precioUnitario', 'cantidad', 'precioTotal')"></td>
                                    <td style="width:140px"><input type="text" class="form-control campoFormulario" id="precioTotal"></td>

                                    </tr>
                                    <tr>
                                        <button id="add-row-button" class="btn btn-primary btn-sm" type="button" onclick="agregarFila()">+</button>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="rowCount" value="1">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 campo">
                            <label for="dias">Días</label>
                            <input type="text" class="form-control campoFormulario" id="dias">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 campo">
                            <label for="mano-obra">Mano de obra</label>
                            <input type="text" class="form-control campoFormulario" id="manoObra" onchange="formatoPesoColombiano(this)">
                        </div>
                        <div class="form-group col-md-5 campo">
                            <label for="porcentaje-admin">Porcentaje admin</label>
                            <input type="text" class="form-control campoFormulario" id="porcentajeAdmin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 campo">
                            <label for="porcentaje-utilidad">Porcentaje utilidad</label>
                            <input type="text" class="form-control campoFormulario" id="porcentajeUtilidad">
                        </div>
                        <div class="form-group col-md-3 campo">
                            <label for="alquiler-equipos">Alquiler de equipos</label>
                            <input type="text" class="form-control campoFormulario" id="alquilerEquipos">
                        </div>
                        <div class="form-group col-md-3 campo">
                            <label for="transporte">Transporte</label>
                            <input type="text" class="form-control campoFormulario" id="transporte">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="validarFormulario('formCotizacion','I-cot')">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</body>