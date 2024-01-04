<div class="contenedor">
    <h1 style="color:#138FCB;font-weight:bold">Contratos generados</h1>
    <p>Seleccione el contrato. </p>
    <select class="form-control" id="cotizacionSelect" onchange="cargarContratos()">
    </select>
    <br><br>
    <div id="infoCotizacion">
        <form id="pagoValorContrato" autocomplete="off" style="display:none ">
            <br>
            <div class="card">
                <div class="card-header bg-primary text-white"  id="tituloTarjeta" style="font-weight:bold">
                    
                </div>
                <div class="card-body">
                    <p>Ingrese el valor pagado por porcentaje</p>

                    <input id="documentoId" type="hidden" class="campoFormulario obligatorio">
                    <div class="row">
                        <div class="col-md-2 campo">
                            <label for="pagoPorcentaje1">Pago porcentaje 1</label>
                            <input type="text" class="form-control campoFormulario obligatorio" id="pagoPorcentaje1" readonly>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="valorPago1">Valor pago</label>
                            <input type="text" class="form-control campoFormulario" id="valorPago1" onchange="formatoPesoColombiano(this);calcularTotalRestarContrato( $('#valorTotalCotizacion').text(), $('#valorPago1').val(), $('#valorPago2').val(), $('#valorPago3').val(), $('#valorPago4').val())">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 campo">
                            <label for="pagoPorcentaje2">Pago porcentaje 2</label>
                            <input type="text" class="form-control campoFormulario" id="pagoPorcentaje2" readonly>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="valorPago2">Valor pago</label>
                            <input type="text" class="form-control campoFormulario" id="valorPago2" onchange="formatoPesoColombiano(this);calcularTotalRestarContrato( $('#valorTotalCotizacion').text(), $('#valorPago1').val(), $('#valorPago2').val(), $('#valorPago3').val(), $('#valorPago4').val())">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 campo">
                            <label for="pagoPorcentaje3">Pago porcentaje 3</label>
                            <input type="text" class="form-control campoFormulario" id="pagoPorcentaje3" readonly>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="valorPago3">Valor pago</label>
                            <input type="text" class="form-control campoFormulario" id="valorPago3" onchange="formatoPesoColombiano(this);calcularTotalRestarContrato( $('#valorTotalCotizacion').text(), $('#valorPago1').val(), $('#valorPago2').val(), $('#valorPago3').val(), $('#valorPago4').val())">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 campo">
                            <label for="pagoPorcentaje4">Pago porcentaje 4</label>
                            <input type="text" class="form-control campoFormulario" id="pagoPorcentaje4" readonly>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="valorPago4">Valor pago</label>
                            <input type="text" class="form-control campoFormulario" id="valorPago4" onchange="formatoPesoColombiano(this);calcularTotalRestarContrato( $('#valorTotalCotizacion').text(), $('#valorPago1').val(), $('#valorPago2').val(), $('#valorPago3').val(), $('#valorPago4').val())">
                        </div>
                    </div>
                    <br>
                    <b><p>Valor restante a pagar:
                    <span style="font-size:30px;color:red" id="valorRestante"></span></b></p>
                    <b><p>Valor total a pagar:
                    <span style="font-size:30px;color:red" id="valorTotalCotizacion"></span></b></p>
                    <button type="button" class="btn btn-primary" id="guardarPagosCotizacion" onclick="validarFormulario('pagoValorContrato','I-pagoContrato')">Guardar</button>
                </div>
            </div>
    </div>
</div>