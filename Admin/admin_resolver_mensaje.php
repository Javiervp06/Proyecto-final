<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php");
    exit();
}
require_once "../bdd/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_mensaje'])) {
    $id_mensaje = $_POST['id_mensaje'];
    
    // Actualizamos el estado a 'resuelto' en vez de borrarlo
    $sql = "UPDATE clases SET estado = 'resuelto' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_mensaje);
    
    if ($stmt->execute()) {
        header("Location: admin_mensajes.php?ver=pendientes&msg=resuelto");
    } else {
        header("Location: admin_mensajes.php?ver=pendientes&error=1");
    }
    $stmt->close();
} else {
    header("Location: admin_mensajes.php");
}
$conexion->close();
?>