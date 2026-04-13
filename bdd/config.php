<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "padelorgaz"; 

$conexion = new mysqli($host, $usuario, $clave, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Opcional: para que use UTF-8
$conexion->set_charset("utf8mb4");
?>
