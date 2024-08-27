<?php
session_start();

// Conexión a la base de datos
include '../conexion.php';

// Obtener el ID del producto y la cantidad del formulario POST
$id = isset($_POST['id']) ? $_POST['id'] : '';
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

// Consultar la base de datos para obtener los detalles del producto
$query = "SELECT * FROM productos WHERE id = '" . $conn->real_escape_string($id) . "'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Agregar el producto al carrito
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = array(
            'nombre' => $product['nombre'],
            'precio' => $product['precio'],
            'cantidad' => $cantidad
        );
    }
}

// Redirigir de vuelta a la página anterior o a una página de confirmación
header('Location: productos.php?id=' . $id);
?>