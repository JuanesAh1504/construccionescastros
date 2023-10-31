<?php 
    include_once('config.php');
    include_once("sql.php");
    include_once("functions.php");
    global $conn;
    conectarBaseDeDatos();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch($_POST['case']){
            case "Login":
                //Se reciben los datos de parámetros enviados en el Login
                $nombreUsuario = $_POST['nombreUsuario'];
                $contrasena = $_POST['contrasena'];
                $sqlLogin = sqlQuerySelect("SELECT usuario, contrasena FROM usuarios WHERE usuario = '".$_POST['nombreUsuario']."' AND contrasena = '".$_POST['contrasena']."'");
                if($sqlLogin->num_rows > 0){
                    $mensaje = mostrarAlerta("Iniciando sesión...", "success");
                } else {
                    $mensaje = mostrarAlerta("Nombre de usuario o contraseña inválido.", "danger");
                }
                echo $mensaje;
            break;
        }
    }
?>