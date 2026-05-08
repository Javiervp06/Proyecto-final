<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

// Comprobamos que los datos nos llegan por el formulario (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario']) && isset($_POST['nuevo_nivel'])) {
    
    $id_usuario = intval($_POST['id_usuario']);
    $nuevo_nivel = floatval($_POST['nuevo_nivel']); // Usamos float por si le pones decimales (ej: 3.50)

    // Preparamos la consulta para actualizar solo el nivel de ese usuario
    $sql = "UPDATE usuarios SET nivel = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("di", $nuevo_nivel, $id_usuario); // 'd' para decimal/float, 'i' para entero/int
    
    if ($stmt->execute()) {
        // Si todo va bien, volvemos a la página de jugadores
        header("Location: admin_jugadores.php?msg=nivel_actualizado");
        exit();
    } else {
        echo "Error al actualizar el nivel: " . $conexion->error;
    }
} else {
    // Si alguien intenta entrar a este archivo directamente poniendo la URL, lo echamos
    header("Location: admin_jugadores.php");
    exit();
}
?>