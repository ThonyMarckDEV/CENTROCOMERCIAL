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
