<?php
        // Conexión a la base de datos
        include '../conexion.php';

        // Iniciar la sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Función para eliminar un producto del carrito
        if (isset($_GET['remove'])) {
            $nombre = $conn->real_escape_string($_GET['remove']);
            // Eliminar el producto del carrito en la sesión
            if (isset($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $key => $item) {
                    if ($item['nombre'] == $nombre) {
                        unset($_SESSION['carrito'][$key]);
                        // Reindexar el array para evitar huecos en el índice
                        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                        break;
                    }
                }
            }
            // Redirigir para evitar que el formulario se envíe de nuevo al actualizar la página
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>
        <!-- HTML para la barra lateral (sidebar) -->
        <div id="mySidebar" class="sidebar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <h2 style="margin-left: 50px;">Carrito</h2>
            <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
                <div class="cart-items-container">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $item):
                        // Obtener la imagen y precio del producto desde la base de datos usando el nombre
                        $nombre = $conn->real_escape_string($item['nombre']);
                        $query = "SELECT imagen, precio FROM productos WHERE nombre = '$nombre'";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $product = $result->fetch_assoc();
                            $imagen = base64_encode($product['imagen']);
                            $precio = $product['precio'];
                            $subtotal = $item['cantidad'] * $precio;
                            $total += $subtotal;
                        }
                    ?>
                        <div class="cart-item">
                            <img src="data:image/jpeg;base64,<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="cart-item-details">
                                <p class="product-name"><?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="product-quantity">Cantidad: <?php echo htmlspecialchars($item['cantidad'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <p class="product-price">Precio: S/.<?php echo number_format($precio, 2); ?></p>
                                <p class="product-subtotal">Subtotal: S/.<?php echo number_format($subtotal, 2); ?></p>
                                <!-- Botón para eliminar el producto del carrito -->
                                <a href="?remove=<?php echo urlencode($item['nombre']); ?>" class="remove-btn">Eliminar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-total">
                    <p><strong>Total:</strong> S/.<?php echo number_format($total, 2); ?></p>
                </div>
                <!-- Botón para realizar la compra -->
                <div class="cart-checkout">
                    <a href="comprar.php" class="checkout-btn">Comprar</a>
                </div>
            <?php else: ?>
                <p>El carrito está vacío.</p>
            <?php endif; ?>
        </div>
