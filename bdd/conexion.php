<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // si usas XAMPP, normalmente está vacío
$base_datos = "padel"; // el nombre de tu base de datos

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
