<?php
// Configuración de la conexión a la base de datos
$servername = "127.0.0.1";  // Cambiar localhost por la dirección IP local
$username = "root";         // Usuario por defecto de XAMPP
$password = "";             // Contraseña vacía por defecto
$dbname = "control_maquinas";  // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $serial = $_POST['serial'];
    $maquina = $_POST['maquina'];
    $conductor = $_POST['conductor'];
    $observaciones = $_POST['observaciones'];

    // Escapar los datos para evitar inyecciones SQL
    $serial = $conn->real_escape_string($serial);
    $maquina = $conn->real_escape_string($maquina);
    $conductor = $conn->real_escape_string($conductor);
    $observaciones = $conn->real_escape_string($observaciones);

    // Preparar la consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO novedades_maquinas (serial, maquina, conductor, observaciones)
            VALUES ('$serial', '$maquina', '$conductor', '$observaciones')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // Redirigir al formulario con un mensaje de éxito
        header("Location: formulario.html?success=true");
        exit();  // Asegura que no se ejecute más código después de la redirección
    } else {
        // Mostrar el error si hay problemas con la consulta
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
