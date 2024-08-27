<?php
// Conexión a la base de datos
include '../conexion.php';

// Obtener el parámetro ID del producto desde GET
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Consultar la base de datos para obtener los detalles del producto
$query = "SELECT * FROM productos WHERE id = '" . $conn->real_escape_string($id) . "'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Ver Producto</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/verproductosPC.css">
        <link rel="stylesheet" href="../css/verProductoMobile.css">
    </head>
    <body>

        <header class="navbar">
            <h1>Centro Comercial</h1>
            <?php include 'navbarUSER.php'; ?>
        </header>

        <div class="product-details">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['imagen']); ?>" alt="<?php echo $product['nombre']; ?>">
            <div class="product-info">
                <h1><?php echo $product['nombre']; ?></h1>
                <p><?php echo $product['descripcion']; ?></p>
                <p><strong>Precio:</strong> S/.<?php echo $product['precio']; ?></p>
                <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
                
                <form method="POST" action="agregarCarrito.php">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" min="1" max="<?php echo $product['stock']; ?>" required>
                    <button type="submit">Agregar al Carrito</button>
                </form>
            </div>
        </div>
    </body>
    </html>

    <?php
} else {
    echo '<p>Producto no encontrado.</p>';
}
?>