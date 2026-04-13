<?php
echo "Entrando en guardar_reserva.php";

require_once "config.php";

$dia = $_POST['dia'];
$hora = $_POST['hora'];
$hora_fin = $_POST['hora_fin'];
$pista = $_POST['pista'];
$nivel = $_POST['nivel'];
$jugadores = $_POST['jugadores'];

$sql = "INSERT INTO reservas (dia, hora_inicio, hora_fin, pista_id, nivel, jugadores)
        VALUES ('$dia', '$hora', '$hora_fin', '$pista', '$nivel', '$jugadores')";

if ($conexion->query($sql)) {
    echo "Reserva guardada correctamente";
} else {
    echo "Error: " . $conexion->error;
}
var_dump($_POST);

?>

