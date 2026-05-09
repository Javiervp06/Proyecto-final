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

// SISTEMA AUTO-LOGIN ("RECORDARME")
// Asegurarnos de que la sesión esté iniciada para poder usar $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si NO hay sesión iniciada, pero SÍ existe la Cookie "recuerdame_id"
if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['recuerdame_id'])) {
    
    $id_cookie = intval($_COOKIE['recuerdame_id']);
    
    // Buscamos a ese usuario en la base de datos
    $sql_cookie = "SELECT id, nombre, alias, rol FROM usuarios WHERE id = $id_cookie";
    $res_cookie = $conexion->query($sql_cookie);
    
    if ($res_cookie && $res_cookie->num_rows === 1) {
        $user_cookie = $res_cookie->fetch_assoc();
        
        // Reconstruimos la sesión automáticamente
        $_SESSION["usuario_id"] = $user_cookie["id"];
        $_SESSION["usuario_nombre"] = $user_cookie["nombre"];
        $_SESSION["usuario_alias"] = $user_cookie["alias"];
        $_SESSION["rol"] = $user_cookie["rol"];
    }
}
?>