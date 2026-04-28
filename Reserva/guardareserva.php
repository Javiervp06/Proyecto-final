<?php
session_start();
require_once "../bdd/config.php";

// Usamos la misma variable de sesión que usas en confirmacion1.php
$id_usuario = $_SESSION['usuario_id'] ?? null;

if (!$id_usuario) {
    die("Error: Debes iniciar sesión para reservar.");
}

$dia = $_POST['dia'];
$hora = $_POST['hora'];
$hora_fin = $_POST['hora_fin'];
$pista = $_POST['pista'];
$nivel = $_POST['nivel'];
$jugadores = (int)$_POST['jugadores']; // Plazas que quiere reservar

// 1. COMPROBAR PLAZAS LIBRES (Para que no se sobrepase el límite de 4)
$sql_check = "SELECT SUM(jugadores) as total FROM reservas WHERE dia=? AND hora_inicio=? AND pista_id=?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("ssi", $dia, $hora, $pista);
$stmt_check->execute();
$res_check = $stmt_check->get_result();
$row_check = $res_check->fetch_assoc();
$total_actual = (int)$row_check['total'];

if (($total_actual + $jugadores) > 4) {
    die("Error: No hay suficientes plazas disponibles para esta reserva.");
}

// 2. INSERTAR LA RESERVA DE FORMA SEGURA (Sentencias Preparadas)
$sql = "INSERT INTO reservas (dia, hora_inicio, hora_fin, pista_id, id_usuario, nivel, jugadores) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssiisi", $dia, $hora, $hora_fin, $pista, $id_usuario, $nivel, $jugadores);

if ($stmt->execute()) {
    // Al guardar, devolvemos al usuario a la vista de las reservas para que vea su foto
    header("Location: reserva.php");
    exit;
} else {
    echo "Error: " . $conexion->error;
}
?>