<?php
// Incluir el archivo de configuración que inicia la sesión
require '../conexion.php';
session_start(); // Asegúrate de iniciar la sesión

// Verificar si la sesión está iniciada
if (isset($_SESSION['correo'])) {
    // Obtener el correo del usuario de la sesión
    $correo = $_SESSION['correo'];

    // Actualizar el estado del usuario a loggedOff en la base de datos
    $sql = "UPDATE usuarios SET status = 'loggedOff' WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->close();

    // Cerrar la sesión y redirigir al formulario de inicio de sesión
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión

    header('Location: ../index.php');
    exit();
} else {
    // Si no hay sesión iniciada, mostrar un mensaje de error o redirigir a alguna otra página
    echo "No hay sesión iniciada.";
    // O redirigir a alguna otra página
    // header('Location: alguna_pagina.php');
    exit();
}
?>