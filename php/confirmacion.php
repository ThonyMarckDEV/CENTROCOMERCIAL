<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si se ha pasado el nombre del archivo PDF
if (!isset($_GET['pdf'])) {
    header('Location: index.php'); // Redirigir a la página principal si no se proporciona el PDF
    exit();
}

$pdf_file = $_GET['pdf'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
    <link rel="stylesheet" href="../css/confirmarPC.css">
    <link rel="stylesheet" href="../css/confirmarMobile.css">
</head>

<style>
     /* Estilos generales para la página */
     body {
        font-family: Arial, sans-serif;
        color: #ffffff;
        background-color: #f5f5f5; /* Fondo claro para un contraste elegante */
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        max-width: 1200px;
        margin: 20px auto;
        background-color: #fff; /* Fondo blanco para el contenedor */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave para darle profundidad */
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #000; /* Títulos en negro para resaltar */
    }

    p {
        margin: 10px 0;
        font-size: 16px;
        color: #000;
    }

    a {
        color: #ffffff; /* Enlaces en negro para el esquema de colores */
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline; /* Subrayado al pasar el ratón */
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #000; /* Botón negro */
        color: #fff; /* Texto blanco en el botón */
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #333; /* Botón negro más oscuro al pasar el ratón */
    }
</style>

<body>
    <div class="container">
        <h1>Compra Confirmada</h1>
        <p>Tu compra ha sido procesada exitosamente.</p>
        <p>Puedes descargar tu boleta de compra desde el siguiente enlace:</p>
        <button><a href="../pdfs/<?php echo htmlspecialchars($pdf_file, ENT_QUOTES, 'UTF-8'); ?>" class="button" download>Descargar Boleta</a></button>
        <button><a href="indexUSER.php" class="button">Regresar a la página principal</a></button>
    </div>
</body>
</html>
