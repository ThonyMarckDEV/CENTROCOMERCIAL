<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener productos
$sql = "SELECT nombre, descripcion, precio, imagen FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Convertir datos binarios a base64
        $imageData = base64_encode($row["imagen"]);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo '<div class="product-item">';
        echo '<img src="' . $imageSrc . '" alt="' . htmlspecialchars($row["nombre"]) . '">';
        echo '<h2>' . htmlspecialchars($row["nombre"]) . '</h2>';
        echo '<p>' . htmlspecialchars($row["descripcion"]) . '</p>';
        echo '<span>S/.' . htmlspecialchars($row["precio"]) . '</span>';
        echo '</div>';
    }
} else {
    echo "<p>No hay productos disponibles.</p>";
}

// Cerrar la conexión
$conn->close();
?>