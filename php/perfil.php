<?php
include '../conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['correo'];

// Obtener información del usuario
$sql = "SELECT nombres, apellidos, dni, direccion, telefono, correo FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Actualizar información del usuario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $sql_update = "UPDATE usuarios SET nombres = ?, apellidos = ?, dni = ?, direccion = ?, telefono = ? WHERE correo = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssss", $nombres, $apellidos, $dni, $direccion, $telefono, $correo);
    if ($stmt_update->execute()) {
        header("Location: indexUser.php");
        echo '<p class="success-message">Información actualizada con éxito.</p>';
        exit();
    } else {
        echo '<p class="error-message">Error al actualizar la información.</p>';
    }
    $stmt_update->close();

    // Volver a cargar la información del usuario después de la actualización
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfilPC.css">
    <link rel="stylesheet" href="../css/perfilMobile.css">
</head>
<body>
    <header>
        <h1>Perfil de Usuario</h1>
    </header>

    <main>
        <div class="profile-info">
            <form method="post" action="">
                <div class="info-item">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($user['nombres']); ?>" readonly>
                    <button type="button" class="edit-btn" onclick="toggleEdit('nombres')">Editar</button>
                </div>
                <div class="info-item">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($user['apellidos']); ?>" readonly>
                    <button type="button" class="edit-btn" onclick="toggleEdit('apellidos')">Editar</button>
                </div>
                <div class="info-item">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($user['dni']); ?>" readonly>
                    <button type="button" class="edit-btn" onclick="toggleEdit('dni')">Editar</button>
                </div>
                <div class="info-item">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($user['direccion']); ?>" readonly>
                    <button type="button" class="edit-btn" onclick="toggleEdit('direccion')">Editar</button>
                </div>
                <div class="info-item">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>" readonly>
                    <button type="button" class="edit-btn" onclick="toggleEdit('telefono')">Editar</button>
                </div>
                <input type="submit" value="Guardar cambios" class="submit-btn">
            </form>
        </div>
    </main>

    <script>
        function toggleEdit(field) {
            const input = document.getElementById(field);
            input.readOnly = !input.readOnly;
            input.focus();
        }
    </script>
</body>
</html>