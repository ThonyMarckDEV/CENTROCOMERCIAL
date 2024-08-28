<?php
// Conexión a la base de datos
include '../conexion.php';

// Obtener el parámetro de categoría desde GET
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Construir la consulta SQL con filtros
$query = "SELECT * FROM productos WHERE 1=1"; // 1=1 permite agregar condiciones adicionales fácilmente

if ($categoria != '') {
    $categoria = $conn->real_escape_string($categoria); // Escapar la categoría
    $query .= " AND categoria = '$categoria'";
}

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        /* Estilo para quitar el subrayado de los enlaces */
        a {
            text-decoration: none;
        }
        
        /* Contenedor principal con padding-top para elevar los productos */
        .products-container {
            display: flex;
            justify-content: center;
            padding-top: -1000px; /* Ajusta este valor para controlar la distancia desde la parte superior */
        }

        /* Estilos para la cuadrícula de productos */
        .products-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Centrar los productos horizontalmente */
        }

        .product-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px;
        }

        .product-item img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .product-item h2 {
            font-size: 1em;
            margin: 10px 0;
        }

        .product-item p {
            font-size: 0.9em;
            color: #555;
        }

        .product-item p strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="products-container">
        <?php
        if ($result->num_rows > 0) {
            echo '<div class="products-grid">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<a href="verProducto.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') . '">';
                echo '<h2>' . htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') . '</h2>';
                echo '<p>' . htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p><strong>Precio:</strong> S/.' . htmlspecialchars($row['precio'], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No se encontraron productos.</p>';
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
</body>
</html>
