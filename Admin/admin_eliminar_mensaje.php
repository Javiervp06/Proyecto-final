<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_mensaje'])) {
    
    $id_mensaje = intval($_POST['id_mensaje']);

    $sql = "DELETE FROM clases WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_mensaje);
    
    if ($stmt->execute()) {
        header("Location: admin_mensajes.php?msg=resuelto");
        exit();
    } else {
        echo "Error al archivar el mensaje: " . $conexion->error;
    }
} else {
    header("Location: admin_mensajes.php");
    exit();
}
?>