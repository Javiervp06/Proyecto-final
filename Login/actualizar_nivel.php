<?php
session_start();
require_once "../bdd/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["usuario_id"])) {
    $reserva_id = $_POST['reserva_id'];
    $resultado = $_POST['resultado'];
    $usuario_id = $_SESSION["usuario_id"];

    // 1. Marcamos la reserva con el resultado
    $sql = "UPDATE reservas SET resultado = '$resultado' WHERE id = $reserva_id AND id_usuario = $usuario_id";
    
    if ($conexion->query($sql)) {
        // 2. Calculamos el ajuste
        $puntos = ($resultado == 'victoria') ? 0.05 : -0.03;
        
        // 3. Actualizamos el nivel del usuario (Límite 1.0 a 7.0)
        $sql_nivel = "UPDATE usuarios SET nivel = LEAST(7.0, GREATEST(1.0, nivel + $puntos)) WHERE id = $usuario_id";
        $conexion->query($sql_nivel);
    }
}
header("Location: perfil.php"); // Volvemos al perfil para ver el cambio
exit;