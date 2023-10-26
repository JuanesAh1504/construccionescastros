<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="contenedor">
    <br><br>
    <h4 style="color: #00535E;font-weight:bold">Ingrese los datos de Cotización</h4>
    <p>Crea cotizaciones de todos tus productos o servicios y lleva un mejor control.</p>
    <div class="card">
        <div class="card-header bg-primary text-white" style="font-weight:bold">
            Información general
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="form-group">
                        <label for="areas">Organización / Empresa</label>
                        <input type="text" class="form-control" id="areas">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6" id="materiales-container">
                        <label>Materiales</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="material[]">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" onclick="agregarFila()" type="button" id="agregar-material">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="areas">Áreas m2 - unidades</label>
                        <input type="text" class="form-control" id="areas">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="dias">Días</label>
                        <input type="text" class="form-control" id="dias">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-5">
                        <label for="mano-obra">Mano de obra</label>
                        <input type="text" class="form-control" id="mano-obra">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="porcentaje-admin">Porcentaje admin</label>
                        <input type="text" class="form-control" id="porcentaje-admin">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-5">
                        <label for="porcentaje-utilidad">Porcentaje utilidad</label>
                        <input type="text" class="form-control" id="porcentaje-utilidad">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="alquiler-equipos">Alquiler de equipos</label>
                        <input type="text" class="form-control" id="alquiler-equipos">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="transporte">Transporte</label>
                        <input type="text" class="form-control" id="transporte">
                    </div>
                </div>
                <!--
                <div class="form-group col-3" id="materiales-container">
                    <label>Materiales</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="material[]">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="agregarFila()" type="button" id="agregar-material">+</button>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                 -->
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>
