<?php
session_start();
header('Content-Type: application/json');
require_once "../bdd/config.php";

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$recordarme = isset($_POST["remember"]) ? true : false; // DETECTAMOS SI MARCÓ LA CASILLA

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "mensaje" => "Completa todos los campos."]);
    exit;
}

// AÑADIMOS 'rol' A LA CONSULTA SELECT DE LA BASE DE DATOS
$sql = "SELECT id, nombre, alias, password, rol FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($password, $usuario["password"])) {
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        $_SESSION["usuario_alias"] = $usuario["alias"];
        
        // GUARDAMOS EL ROL EN LA SESIÓN
        $_SESSION["rol"] = $usuario["rol"];

        // MAGIA AQUÍ: Si marcó "Recordarme", creamos una Cookie válida por 30 días
        if ($recordarme) {
            setcookie("recuerdame_id", $usuario["id"], time() + (30 * 24 * 60 * 60), "/");
        }

        echo json_encode(["status" => "success", "mensaje" => "¡Bienvenido, " . $usuario['alias'] . "!"]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["status" => "error", "mensaje" => "El correo no está registrado."]);
}
?>