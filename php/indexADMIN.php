<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/indexADMINPC.css">
        <link rel="stylesheet" href="../css/indexADMINMobile.css">
    </head>

    <body>
        <header class="navbar">
            <h1>Centro Comercial</h1>
            <nav>
                <ul>
                    <li class="login">
                        <a href="perfil.php">
                            <img src="../img/sesion.png" alt="Iniciar sesión">
                        </a>
                    </li>
                    <li><a href="#">Agregar Productos</a></li>
                    <li><a href="#">Administrar ventas</a></li>
                    <li class="logout">
                        <a href="/php/logout.php">
                            <img src="../img/logout.jpg" alt="Cerrar sesión">
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        <div id="main">
            <main class="product-list">
                <h1 style="text-align: center; margin-top: 10px;">Productos</h1>
                <div class="form-container">
                    <form method="GET" action="">
                        <label for="categoria">Categoría:</label>
                        <select name="categoria" id="categoria">
                            <option value="">Todas</option>
                            <?php
                            // Conexión a la base de datos
                            include '../conexion.php';

                            // Obtener todas las categorías
                            $query_categorias = "SELECT DISTINCT categoria FROM productos WHERE categoria IS NOT NULL";
                            $result_categorias = $conn->query($query_categorias);

                            while ($row_categoria = $result_categorias->fetch_assoc()) {
                                echo "<option value=\"" . $row_categoria['categoria'] . "\">" . $row_categoria['categoria'] . "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit">Buscar</button>
                    </form>
                </div>
              
            </main>
        </div>

        <main class="product-list">
        <?php include '../listarproductos.php'; ?>
        </main>
    
        <footer>
            <p>&copy; 2024 Centro Comercial. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>