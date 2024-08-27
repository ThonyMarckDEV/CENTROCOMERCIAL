<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/indexUSERMobile.css">
        <link rel="stylesheet" href="../css/indexUSERPC.css">
        <link rel="stylesheet" href="../css/sidebarPC.css">
        <link rel="stylesheet" href="../css/sidebarmobile.css">
    </head>

    <body>
        <header class="navbar">
            <h1>Centro Comercial</h1>
            <?php include 'navbarUSER.php'; ?>
        </header>

        <!-- Inclusión del Sidebar -->
        <?php include 'sidebar.php'; ?>

        <h1 style="text-align: center; margin-top: 10px;">Nuestras Recomendaciones!!!</h1>
        
        <main class="product-list">
        <?php include '../listarrecomendaciones.php'; ?>
        </main>
    
        <footer>
            <p>&copy; 2024 Centro Comercial. Todos los derechos reservados.</p>
        </footer>

        <script src="../js/sidebar.js"></script>
    </body>
</html>