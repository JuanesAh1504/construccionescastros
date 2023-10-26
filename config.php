<?php
    global $conn;
    function conectarBaseDeDatos() {
        global $conn;

        // Datos de conexión (deberían estar en un archivo de configuración externo)
        $host = "localhost";
        $dbname = "castro'ssolucion";
        $username = "root";
        $password = "";
    
        // Crear una conexión a la base de datos
        $conn = new mysqli($host, $username, $password, $dbname);
    
        // Verificar si hay errores de conexión
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }
    
        return $conn;
    }
    
    function cerrarConexion($conn) {
        $conn->close();
    }
    
?>
