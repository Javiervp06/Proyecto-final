<?php
require_once "../bdd/config.php";

$dia = $_POST['dia'];
$hora = $_POST['hora'];
$hora_fin = $_POST['hora_fin'];
$pista = $_POST['pista'];
$nivel = $_POST['nivel'];
$jugadores = $_POST['jugadores'];

session_start();
$id_usuario = $_SESSION['id'];

$sql = "INSERT INTO reservas (dia, hora_inicio, hora_fin, pista_id, id_usuario, nivel, jugadores)
        VALUES ('$dia', '$hora', '$hora_fin', '$pista', '$id_usuario', '$nivel', '$jugadores')";


if ($conexion->query($sql)) {
    header("Location: reservas.php");
    exit;
} else {
    echo "Error: " . $conexion->error;
}
?>
