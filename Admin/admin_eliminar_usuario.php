<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login/login.php?error=acceso_denegado");
    exit();
}
require_once "../bdd/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])) {
    
    $id_usuario = intval($_POST['id_usuario']);

    /* * NOTA IMPORTANTE: Si el usuario tiene reservas a su nombre, 
     * primero debemos borrar sus reservas para que la base de datos no dé error.
     */
    $sql_reservas = "DELETE FROM reservas WHERE id_usuario = ?";
    $stmt_reservas = $conexion->prepare($sql_reservas);
    $stmt_reservas->bind_param("i", $id_usuario);
    $stmt_reservas->execute();

    // Ahora sí, borramos al usuario
    $sql_usuario = "DELETE FROM usuarios WHERE id = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $id_usuario);
    
    if ($stmt_usuario->execute()) {
        header("Location: admin_jugadores.php?msg=usuario_eliminado");
        exit();
    } else {
        echo "Error al eliminar al usuario: " . $conexion->error;
    }
} else {
    header("Location: admin_jugadores.php");
    exit();
}
?>