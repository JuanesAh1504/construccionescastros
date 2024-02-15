<body onload="generarNumeroAleatorio()">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="contenedor">
        <?php
            include_once("config.php"); 
            include_once("sql.php"); 
            $esEdicion = false;

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT documentoId, tipoContribuyente, regimen, nombreComercial, tipoDocumento, numeroDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, razonSocial, ciudad, direccion, telefonoCelular, correoElectronico FROM clientes WHERE documentoId = $id"; // Reemplaza con tu consulta SQL
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
                <div class="card-body formulario">
                    <div class="row">
                        <div class="col-md-3 campo obligatorio">
                            <label for="documentoId">Id cliente</label>
                            <input type="text" class="form-control" id="documentoId" name="documentoId" value="<?php if($esEdicion){echo $id;}?>" readonly>
                        </div>
                        <div class="col-md-3 campo obligatorio">
                            <label for="tipoContribuyente">Tipo de contribuyente</label>
                            <select id="tipoContribuyente" class="form-control">
                                <option value="" <?php if (!isset($fila['tipoContribuyente']) || $fila['tipoContribuyente'] === "") { echo 'selected'; } ?>></option>
                                <option value="Persona natural y asimiladas" <?php if (isset($fila['tipoContribuyente']) && $fila['tipoContribuyente'] === "Persona natural y asimiladas") { echo 'selected'; } ?>>Persona natural y asimiladas</option>
                                <option value="Persona jurídica y asimiladas" <?php if (isset($fila['tipoContribuyente']) && $fila['tipoContribuyente'] === "Persona jurídica y asimiladas") { echo 'selected'; } ?>>Persona jurídica y asimiladas</option>
                            </select>
                        </div>
                        <div class="col-md-3 campo obligatorio">
                            <label for="regimen">Régimen</label>
                            <select id="regimen" class="form-control">
                                <option value="" <?php if (!isset($fila['regimen']) || $fila['regimen'] === "") { echo 'selected'; } ?>></option>
                                <option value="No responsable de IVA" <?php if (isset($fila['regimen']) && $fila['regimen'] === "No responsable de IVA") { echo 'selected'; } ?>>No responsable de IVA</option>
                                <option value="Responsable del impuesto sobre las ventas - IVA" <?php if (isset($fila['regimen']) && $fila['regimen'] === "Responsable del impuesto sobre las ventas - IVA") { echo 'selected'; } ?>>Responsable del impuesto sobre las ventas - IVA</option>
                            </select>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="nombreComercial">Nombre comercial</label>
                            <input type="text" id="nombreComercial" class="form-control" value="<?php if($esEdicion){echo $fila['nombreComercial'];}?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4 campo obligatorio">
                            <label for="tipoDocumento">Tipo de documento</label>
                            <select id="tipoDocumento" class="form-control">
                                <option value="" <?php if (!isset($fila['tipoDocumento']) || $fila['tipoDocumento'] === "") { echo 'selected'; } ?>></option>
                                <option value="Registro civil" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Registro civil") { echo 'selected'; } ?>>Registro civil</option>
                                <option value="Tarjeta de identidad" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Tarjeta de identidad") { echo 'selected'; } ?>>Tarjeta de identidad</option>
                                <option value="Cédula de ciudadanía" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Cédula de ciudadanía") { echo 'selected'; } ?>>Cédula de ciudadanía</option>
                                <option value="Tarjeta de extranjería" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Tarjeta de extranjería") { echo 'selected'; } ?>>Tarjeta de extranjería</option>
                                <option value="Cédula extranjería" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Cédula extranjería") { echo 'selected'; } ?>>Cédula extranjería</option>
                                <option value="NIT" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "NIT") { echo 'selected'; } ?>>NIT</option>
                                <option value="Pasaporte" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Pasaporte") { echo 'selected'; } ?>>Pasaporte</option>
                                <option value="Documento de identificación extranjero" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "Documento de identificación extranjero") { echo 'selected'; } ?>>Documento de identificación extranjero</option>
                                <option value="NUIP" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "NUIP") { echo 'selected'; } ?>>NUIP</option>
                                <option value="PEP" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "PEP") { echo 'selected'; } ?>>PEP</option>
                                <option value="NIT de otro país" <?php if (isset($fila['tipoDocumento']) && $fila['tipoDocumento'] === "NIT de otro país") { echo 'selected'; } ?>>NIT de otro país</option>
                            </select>
                        </div>
                        <div class="col-md-3 campo obligatorio">
                            <label for="numeroDocumento">Número de documento</label>
                            <input type="text" id="numeroDocumento" class="form-control" value="<?php if($esEdicion){echo $fila['numeroDocumento'];}?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3 campo">
                            <label for="primerNombre">Primer nombre</label>
                            <input type="text" id="primerNombre" class="form-control" value="<?php if($esEdicion){echo $fila['primerNombre'];}?>">
                        </div>
                        <div class="col-md-3 campo">
                            <label for="segundoNombre">Segundo nombre</label>
                            <input type="text" id="segundoNombre" class="form-control" value="<?php if($esEdicion){echo $fila['segundoNombre'];}?>">
                        </div>
                        <div class="col-md-3 campo">
                            <label for="primerApellido">Primer apellido</label>
                            <input type="text" id="primerApellido" class="form-control" value="<?php if($esEdicion){echo $fila['primerApellido'];}?>">
                        </div>
                        <div class="col-md-3 campo">
                            <label for="segundoApellido">Segundo apellido</label>
                            <input type="text" id="segundoApellido" class="form-control" value="<?php if($esEdicion){echo $fila['segundoApellido'];}?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-5 campo">
                            <label for="razonSocial">Razón social</label>
                            <input type="text" id="razonSocial" class="form-control" value="<?php if($esEdicion){echo $fila['razonSocial'];}?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3 campo obligatorio">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" id="ciudad" class="form-control" value="<?php if($esEdicion){echo $fila['ciudad'];}?>">
                        </div>
                        <div class="col-md-3 campo obligatorio">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" class="form-control" value="<?php if($esEdicion){echo $fila['direccion'];}?>">
                        </div>
                        <div class="col-md-3 campo obligatorio">  
                            <label for="telefonoCelular">Teléfono / Celular</label>
                            <input type="text" id="telefonoCelular" class="form-control" value="<?php if($esEdicion){echo $fila['telefonoCelular'];}?>">
                        </div>
                        <div class="col-md-3 campo obligatorio">  
                            <label for="correoElectronico">Correo electrónico</label>
                            <input type="text" id="correoElectronico" class="form-control" value="<?php if($esEdicion){echo $fila['correoElectronico'];}?>">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="<?php if($esEdicion) {echo 'guardar(2, \'user\')';} else { echo 'guardar(1, \'user\')';} ?>">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</body>