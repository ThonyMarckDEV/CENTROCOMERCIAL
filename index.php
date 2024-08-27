<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/indexPC.css">
    <link rel="stylesheet" href="css/indexMobile.css">
</head>
<body>
    <header class="navbar">
        <h1>Centro Comercial</h1>
        <nav>
            <ul>
                <li class="login">
                    <a href="/php/login.php">
                        <img src="img/sesion.png" alt="Iniciar sesión">
                    </a>
                </li>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Acerca de</a></li>
            </ul>
        </nav>
    </header>

    <h1 style="text-align: center; margin-top: 10px;">Nuestras Recomendaciones!!!</h1>

    <main class="product-list">
        <?php include 'listarrecomendaciones.php'; ?>
    </main>

    <footer>
        <p>&copy; 2024 Centro Comercial. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
