<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styleMobile.css">
        <link rel="stylesheet" href="css/stylePC.css">
    </head>

    <body>
        <header class="navbar">
            <h1>Centro Comercial</h1>
            <nav>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Acerca de</a></li>
                </ul>
            </nav>
        </header>

        <main class="product-list">
        <?php include 'php/productos.php'; ?>
        </main>
    
        <footer>
            <p>&copy; 2024 Centro Comercial. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>