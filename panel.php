<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Roboto&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/comun.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <title>Panel</title>
</head>
<body>
    <aside class="menuContenido" id="menuContenido">
        <div class="head">
            <div class="profile">
                <img src="https://static.vecteezy.com/system/resources/previews/019/896/008/original/male-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png" alt="">
                <p>Juan Esteban Álvarez</p>
            </div>
            <i class='bx bx-menu' ></i>
        </div>
        <div class="options">
            <div>
                <i class='bx bxs-dashboard' ></i>
                <span class="option">Inicio</span>
            </div>
            <div  onclick="loadContent('crearCliente.php')" oncontextmenu="listarDocumentos('listarClientes.php')">
                <i class='bx bxs-user-detail' ></i>
                <span class="option">Clientes</span>
            </div>
            <div onclick="loadContent('cotizacion.php')" oncontextmenu="listarDocumentos('listarCotizacion.php')" >
                <i class='bx bxs-user-detail' ></i>
                <span class="option">Cotización</span>
            </div>
            <div>
                <i class='bx bxs-cog'></i>
                <span class="option">Configuración</span>
            </div>
            <div>
                <i class='bx bxs-log-out'></i>
                <span class="option">Cerrar sesión</span>
            </div>
        </div>
    </aside>
    <div id="workspace"></div>
    <div id="error-container"></div>   
    <div class="respuesta"></div>
    <script src="js/menu.js"></script>
    <script src="js/functions.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/validarDatos.js"></script>
    <script src="js/envioDatos.js"></script>

</body>
</html>