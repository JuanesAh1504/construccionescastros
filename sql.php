<?php 
    include_once("config.php");
    conectarBaseDeDatos();
    function sqlQuerySelect($sql) {
        global $conn;
            $resultado = $conn->query($sql);
        if ($resultado) {
            return $resultado;
        } else {
            echo "Error en la consulta: " . $conn->error;
            return false;
        }
    }   

    function sqlInsertUpdate($sql) {
        global $conn; // Suponiendo que $conn es tu variable de conexión global
    
        if ($conn->query($sql) === TRUE) {
            return true; // La consulta se ejecutó con éxito
        } else {
            return false; // Hubo un error en la ejecución de la consulta
        }
    }

    function sqlQueryDelete($sql){
        global $conn;
        if ($conn->query($sql) === TRUE) {
            return true; // Eliminación exitosa
        } else {
            return false; // Error en la eliminación
        }
    }

    function limpiarDatos($dato) {
        global $conn;
        if (is_numeric($dato)) {
            // Escapar la cadena para prevenir inyección SQL
            $dato = $conn->real_escape_string($dato);
            return $dato;
        } else {
            return false; // Datos no válidos
        }
    }
    
    /* // Obtener el valor del input desde la solicitud GET
    $valorInput = $_GET['valorInput'];

    // Conectar a la base de datos
    $conn = conectarBaseDeDatos();

    // Consulta a la base de datos para obtener resultados que coincidan con el valor del input
    $sql = "SELECT razonSocial FROM clientes WHERE razonSocial LIKE '%$valorInput%'";
    $result = $conn->query($sql);

    // Crear un array para almacenar los resultados
    $data = array();

    // Obtener los resultados y almacenarlos en el array
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row['razonSocial'];
        }
    }

    // Devolver los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($data);

    // Cerrar la conexión a la base de datos
    cerrarConexion($conn); */
?>