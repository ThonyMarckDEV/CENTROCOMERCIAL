<?php
$servername = "localhost";
$username = "app";
$password = "123456";
$dbname = "centrocomercial";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos";

// Cerrar conexión (opcional)
$conn->close();
?>
