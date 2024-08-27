<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'USER'; // Tipo por defecto
    $status = 'loggedOff'; // Status por defecto

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la declaración
    $stmt = $conn->prepare("INSERT INTO usuarios (nombres, apellidos, dni, direccion, telefono, correo, password, tipo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nombres, $apellidos, $dni, $direccion, $telefono, $correo, $password_hash, $tipo, $status);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Registro exitoso, redirigir a la página de inicio de sesión con una notificación
        header("Location: login.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

    <head>
    <meta charset="UTF-8">
        <title>Registro</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/registerPC.css">    
        <link rel="stylesheet" href="../css/registerMobile.css">
    </head>

    <body>
        <h1>Registro de Usuario</h1>
        <form method="post" style="width: 230px;">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>
            <br>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
            <br>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni">
            <br>
            <label for="direccion">Dirección:</label>
            <textarea id="direccion" name="direccion"></textarea>
            <br>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">
            <br>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Registrar</button>
        </form>
    </body>
</html> 