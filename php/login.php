<?php
include '../conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Preparar la declaración
    $stmt = $conn->prepare("SELECT password, nombres, apellidos, tipo FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password_hash, $nombres, $apellidos, $tipo);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $password_hash)) {
            $_SESSION['correo'] = $correo;
            $_SESSION['tipo'] = $tipo;
            $_SESSION['nombre_completo'] = $nombres . ' ' . $apellidos;

            // Actualizar el estado del usuario
            $stmt_update = $conn->prepare("UPDATE usuarios SET status = 'loggedOn' WHERE correo = ?");
            $stmt_update->bind_param("s", $correo);
            $stmt_update->execute();
            $stmt_update->close();

            // Redirigir según el tipo de usuario
            switch ($tipo) {
                case 'ADMIN':
                    header('Location: indexADMIN.php');
                    exit();
                case 'USER':
                    header("Location: indexUSER.php");
                    exit();
            }

        } else {
            echo "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        echo "Correo electrónico no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

    <head>    
        <meta charset="UTF-8">
        <title>Inicio de Sesión</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/loginMobile.css">
            <link rel="stylesheet" href="../css/loginPC.css">      
    </head>

    <body>
        <h1>Iniciar Sesión</h1>
        <form method="post" action="">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿Eres nuevo? <a href="register.php">¡Regístrate aquí!</a></p>
    </body>
    
</html>