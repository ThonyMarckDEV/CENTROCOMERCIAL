<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/productosPC.css">
        <link rel="stylesheet" href="../css/productosMobile.css">
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
                <?php include '../listarproductos.php'; ?>
            </main>
        </div>

        <footer>
            <p>&copy; 2024 Centro Comercial. Todos los derechos reservados.</p>
        </footer>

        <script src="../js/sidebar.js"></script>
    </body>
</html>
