<body onload="generarNumeroAleatorio()">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="contenedor">
        <?php
            include_once("config.php"); 
            include_once("sql.php"); 
            $esEdicion = false;

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM cotizacion WHERE documentoId = $id"; // Reemplaza con tu consulta SQL
                $resultado = sqlQuerySelect($sql); // Utiliza tu función sqlQuerySelect

                if ($resultado) {
                    $fila = $resultado->fetch_assoc();
                    $esEdicion = true;
                    // Asigna los valores a las variables
                }
            }
        ?> 
        <form id="formCotizacion" autocomplete="off">
            <br>
            <h4 style="color: #00535E;font-weight:bold"><?php if($esEdicion){echo 'Edite ';}else{echo 'Ingrese ';}?>los datos de Clientes</h4>
            <p><?php if($esEdicion){echo 'Edite ';}else{echo 'Cree ';}?>clientes y lleve un mejor control.</p>
            <div class="card">
                <div class="card-header bg-primary text-white" style="font-weight:bold">
                    Información general
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="documentoId">Id cliente</label>
                            <input type="text" class="form-control campoFormulario" id="documentoId" name="documentoId" value="<?php if($esEdicion){echo $documentoId;}?>" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="tipoContribuyente">Tipo de contribuyente</label>
                            <select id="tipoContribuyente" class="form-control campoFormulario">
                                <option value=""></option>
                                <option value="Persona natural">Persona natural y asimiladas</option>
                                <option value="Persona jurídica">Persona jurídica y asimiladas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="regimen">Régimen</label>
                            <select id="regimen" class="form-control campoFormulario">
                                <option value=""></option>
                                <option value="No responsable de IVA">No responsable de IVA</option>
                                <option value="Responsable del impuesto sobre las ventas - IVA">Responsable del impuesto sobre las ventas - IVA</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="nombreComercial">Nombre comercial</label>
                            <input type="text" id="nombreComercial" class="form-control campoFormulario">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipoDocumento">Tipo de documento</label>
                            <select id="tipoDocumento" class="form-control campoFormulario">
                                <option value=""></option>
                                <option value="Registro civil">Registro civil</option>
                                <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                                <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                                <option value="Tarjeta de extranjería">Tarjeta de extranjería</option>
                                <option value="Cédula extranjería">Cédula extranjería</option>
                                <option value="NIT">NIT</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Documento de identificacion extranjero">Documento de identificacion extranjero</option>
                                <option value="NUIP">NUIP</option>
                                <option value="PEP">PEP</option>
                                <option value="NIT de otro pais">NIT de otro pais</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="numeroDocumento">Número de documento</label>
                            <input type="text" id="numeroDocumento" class="form-control campoFormulario">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="primerNombre">Primer nombre</label>
                            <input type="text" id="primerNombre" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">
                            <label for="segundoNombre">Segundo nombre</label>
                            <input type="text" id="segundoNombre" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">
                            <label for="primerApellido">Primer apellido</label>
                            <input type="text" id="primerApellido" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">
                            <label for="segundoApellido">Segundo apellido</label>
                            <input type="text" id="segundoApellido" class="form-control campoFormulario">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="razonSocial">Razón social</label>
                            <input type="text" id="razonSocial" class="form-control campoFormulario">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" id="ciudad" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">  
                            <label for="telefonoCelular">Teléfono / Celular</label>
                            <input type="text" id="telefonoCelular" class="form-control campoFormulario">
                        </div>
                        <div class="col-md-3">  
                            <label for="correoElectronico">Correo electrónico</label>
                            <input type="text" id="correoElectronico" class="form-control campoFormulario">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="validarFormulario('formCotizacion','<?php if(!$esEdicion){echo 'I-cliente';}else{echo 'U-cliente';}?>')">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</body>