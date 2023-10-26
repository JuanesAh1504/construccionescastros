<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/comun.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/envioDatos.js"></script>
    <script src="js/validarDatos.js"></script>
  </head>
  <body>

    <div class="login-box">
      <img src="https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png" class="avatar" alt="Avatar Image">
      <h1>Iniciar sesión</h1>
      <form autocomplete="off" id="formLoginInicial">
        <div class="campo">
            <label for="nombreUsuario">Nombre de usuario</label>
            <input type="text" class="campoFormulario" placeholder="" id="nombreUsuario" required>
        </div>
        <!-- PASSWORD INPUT -->
        <div class="campo">
            <label for="contrasena">Contraseña</label>
            <input type="password" class="campoFormulario" placeholder="" id="contrasena" required>
        </div>
        <input type="button" class="inputEnviarDatosLogin" value="Iniciar sesión" onclick="validarFormulario('formLoginInicial', 'inputEnviarDatosLogin')">
        <a href="#">¿Olvidó la contraseña?</a><br>
      </form>
    </div>
    <div id="error-container"></div>
    <div class="respuesta"></div>
  </body>
</html>