<?php
// Conexión a la base de datos
include '../conexion.php';

// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: index.php'); // Redirigir a la página principal si el carrito está vacío
    exit();
}

// Procesar la compra
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process'])) {
    // Obtener el método de pago seleccionado
    $metodo_pago = $_POST['metodo_pago'];
    $total = 0;

    // Actualizar el stock y calcular el total
    foreach ($_SESSION['carrito'] as $item) {
        $nombre = $conn->real_escape_string($item['nombre']);
        $cantidad = $item['cantidad'];
        
        // Obtener el precio del producto
        $query = "SELECT precio, stock FROM productos WHERE nombre = '$nombre'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $precio = $product['precio'];
            $stock = $product['stock'];
            
            // Descontar del stock
            if ($stock >= $cantidad) {
                $new_stock = $stock - $cantidad;
                $update_query = "UPDATE productos SET stock = $new_stock WHERE nombre = '$nombre'";
                $conn->query($update_query);
                
                // Calcular el subtotal
                $subtotal = $cantidad * $precio;
                $total += $subtotal;
            } else {
                echo "No hay suficiente stock para el producto: $nombre";
                exit();
            }
        }
    }

    // Generar el PDF de la boleta de compra
    require_once('../fpdf/fpdf.php'); // Asegúrate de que FPDF esté correctamente instalado y configurado

    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Boleta de Compra', 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        }

        function ChapterTitle($title) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, $title, 0, 1, 'L');
            $this->Ln(5);
        }

        function ChapterBody($body) {
            $this->SetFont('Arial', '', 12);
            $this->MultiCell(0, 10, $body);
            $this->Ln();
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetTitle('Boleta de Compra');
    $pdf->ChapterTitle('Detalles de la Compra');

    foreach ($_SESSION['carrito'] as $item) {
        $nombre = htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8');
        $cantidad = $item['cantidad'];
        $query = "SELECT precio FROM productos WHERE nombre = '$nombre'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $precio = $product['precio'];
            $subtotal = $cantidad * $precio;
            $pdf->ChapterBody("Producto: $nombre\nCantidad: $cantidad\nPrecio: S/. " . number_format($precio, 2) . "\nSubtotal: S/. " . number_format($subtotal, 2) . "\n");
        }
    }
    
    $pdf->ChapterTitle('Total');
    $pdf->ChapterBody("Total: S/. " . number_format($total, 2));
    
    $pdf_file = '../pdfs/boleta_' . time() . '.pdf';
    
    // Verificar si el directorio existe y es accesible
    if (!is_dir(dirname($pdf_file))) {
        echo "Directorio para guardar el PDF no existe.";
        exit();
    }
    
    try {
        $pdf->Output('F', $pdf_file);
    } catch (Exception $e) {
        echo 'Error al generar el PDF: ', $e->getMessage();
        exit();
    }

    // Vaciar el carrito después de la compra
    unset($_SESSION['carrito']);

    // Redirigir al usuario a la página de confirmación
    header('Location: confirmacion.php?pdf=' . urlencode($pdf_file));
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Método de Pago</title>
    <link rel="stylesheet" href="../css/comprarMobile.css">
    <link rel="stylesheet" href="../css/comprarPC.css">
</head>
<body>

        <header class="navbar">
            <h1>Centro Comercial</h1>
            <?php include 'navbarUSER.php'; ?>
        </header>

        <style>
                    /* Estilos generales para la página */
    body {
        font-family: Arial, sans-serif;
        color: #333;
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

    h2 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #000; /* Subtítulos en negro */
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .cart-item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd; /* Línea divisoria entre los artículos */
        padding: 10px 0;
    }

    .cart-item img {
        width: 80px; /* Tamaño fijo para las imágenes */
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 15px;
    }

    .cart-item-details {
        flex: 1;
    }

    .product-name,
    .product-quantity,
    .product-price,
    .product-subtotal {
        margin: 0;
        font-size: 14px;
    }

    .product-name {
        font-weight: bold;
    }

    p {
        margin: 5px 0;
    }

    label {
        margin-top: 15px;
        font-weight: bold;
        color: #000;
    }

    select {
        padding: 10px;
        border: 1px solid #ccc; /* Borde gris claro */
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        font-size: 14px;
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

    p strong {
        font-weight: bold;
    }

    /* ==========================================*/
    /*BARRA NAVEGACION*/
    .navbar {
        background-color: #ffffff;
        color: #000000;
        padding: 1.5rem;
        text-align: center;
        border-bottom: 2px solid #000000;
    }
    .navbar h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #000000;
    }
    
    .navbar ul {
        list-style: none;
        display: flex;
        justify-content: center;
        gap: 1rem;
        align-items: center; /* Alinea verticalmente los elementos de la lista */
    }

    .navbar ul li a {
        color: #000000;
        text-decoration: none;
        font-size: 1rem;
    }
    
    
    .navbar ul li a:hover {
        text-decoration: underline;
    }

    /*IMG LOGIN*/

    .navbar ul li.login {
        position: absolute;
        left: 1rem;
        top: 10px;
    }

    .navbar ul li.login img {
        width: 50px; /* Ajusta el tamaño de la imagen */
        height: auto;
        vertical-align: middle; /* Alinea la imagen verticalmente con el texto */
    }
    /*IMG LOGIN*/

    /*IMG LOGOUT*/

    .navbar ul li.logout {
        position: absolute;
        right: 1rem;
        top: 58px;
    }

    .navbar ul li.logout img {
        width: 50px; /* Ajusta el tamaño de la imagen */
        height: auto;
        vertical-align: middle; /* Alinea la imagen verticalmente con el texto */
    }
    /*IMG LOGOUT*/

        /*IMG Carrito*/

        .navbar ul li.carrito {
            position: absolute;
            right: 1rem;
            top: 5px;
        }
    
        .navbar ul li.carrito img {
            width: 50px; /* Ajusta el tamaño de la imagen */
            height: auto;
            vertical-align: middle; /* Alinea la imagen verticalmente con el texto */
        }
        /*IMG Carrito*/


    /* ==========================================*/
    /*BARRA NAVEGACION*/
        </style>


    <div class="container">
        <h1>Seleccionar Método de Pago</h1>
        <form method="POST" action="">
            <h2>Resumen de la Compra</h2>
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $item):
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
                    </div>
                </div>
            <?php endforeach; ?>
            <p><strong>Total:</strong> S/.<?php echo number_format($total, 2); ?></p>
            <label for="metodo_pago">Método de Pago:</label>
            <select id="metodo_pago" name="metodo_pago" required>
                <option value="tarjeta">Tarjeta de Crédito</option>
                <option value="paypal">PayPal</option>
                <option value="efectivo">Efectivo</option>
            </select>
            <button type="submit" name="process">Procesar Compra</button>
        </form>
    </div>
</body>
</html>
