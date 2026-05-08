<?php
// 1. Decimos que vamos a devolver un JSON
header('Content-Type: application/json');

require_once "../bdd/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "errores" => ["Acceso no permitido."]]);
    exit;
}

$nombre = trim($_POST["Nombre"] ?? "");
$apellidos = trim($_POST["Apellidos"] ?? "");
$telefono = trim($_POST["Telefono"] ?? "");
$alias = trim($_POST["Alias"] ?? "");

$email = trim($_POST["new_username"] ?? "");
$confirmar_email = trim($_POST["confirm_email"] ?? "");
$contrasena = $_POST["password"] ?? "";
$confirmar_contrasena = $_POST["confirm_password"] ?? "";

$sexo = $_POST["sexo"] ?? "";
$posicion = $_POST["posicion"] ?? "";
$nivel = $_POST["nivel"] ?? "";
$nivel = str_replace(",", ".", $nivel);

$avatar_ruta = null; // Más adelante haremos la subida de foto
$errores = [];

// ==========================
// VALIDACIONES
// ==========================
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio.";
} else if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
    $errores[] = "El nombre solo puede contener letras.";
} elseif (strlen($nombre) < 2 || strlen($nombre) > 50) {
    $errores[] = "El nombre debe tener entre 2 y 50 caracteres.";
}

if (empty($apellidos)) {
    $errores[] = "Los apellidos son obligatorios.";
} else if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $apellidos)) {
    $errores[] = "Los apellidos solo pueden contener letras y espacios.";
} elseif (strlen($apellidos) < 4 || strlen($apellidos) > 100) {
    $errores[] = "Los apellidos deben tener entre 4 y 100 caracteres.";
}

if (empty($telefono)) {
    $errores[] = "El teléfono es obligatorio.";
} else if (!preg_match("/^\d{9}$/", $telefono)) {
    $errores[] = "El teléfono debe tener 9 dígitos.";
}

if (empty($alias)) {
    $errores[] = "El alias es obligatorio.";
} else if (!preg_match("/^[a-zA-Z0-9]+$/", $alias)) {
    $errores[] = "El alias solo puede contener letras y números sin espacios.";
} elseif (strlen($alias) < 3 || strlen($alias) > 20) {
    $errores[] = "El alias debe tener entre 3 y 20 caracteres.";
}

if (empty($email)) {
    $errores[] = "El correo electrónico es obligatorio.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido.";
} elseif ($email !== $confirmar_email) {
    $errores[] = "Los correos electrónicos no coinciden.";
}

if (empty($contrasena)) {
    $errores[] = "La contraseña es obligatoria.";
} else if (strlen($contrasena) < 6) {
    $errores[] = "La contraseña debe tener al menos 6 caracteres.";
} else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/", $contrasena)) {
    $errores[] = "La contraseña debe contener al menos una mayúscula, una minúscula y un número.";
}

if (empty($confirmar_contrasena)) {
    $errores[] = "Es necesario confirmar la contraseña.";
} else if ($contrasena !== $confirmar_contrasena) {
    $errores[] = "Las contraseñas no coinciden.";
}

if (empty($sexo)) {
    $errores[] = "El sexo es obligatorio.";
} 

if (empty($posicion)) {
    $errores[] = "La posición es obligatoria.";
} 

if ($nivel === "") {
    $errores[] = "El nivel es obligatorio.";
} elseif (!is_numeric($nivel)) {
    $errores[] = "El nivel debe ser un número válido.";
} elseif ($nivel < 1 || $nivel > 7) {
    $errores[] = "El nivel debe estar entre 1 y 7.";
}

// ==========================
// RESPUESTA DE ERRORES O INSERCIÓN
// ==========================
if (!empty($errores)) {
    // Si hay errores, devolvemos el array en formato JSON y paramos aquí.
    echo json_encode(["status" => "error", "errores" => $errores]);
    exit;
}

// COMPROBAR DUPLICADOS (NUEVO)
// Comprobar si el Email ya existe
$sqlEmail = "SELECT id FROM usuarios WHERE email = ?";
$stmtEmail = $conexion->prepare($sqlEmail);
$stmtEmail->bind_param("s", $email);
$stmtEmail->execute();
if ($stmtEmail->get_result()->num_rows > 0) {
    $errores[] = "Este correo electrónico ya está registrado.";
}

// Comprobar si el Alias ya existe
$sqlAlias = "SELECT id FROM usuarios WHERE alias = ?";
$stmtAlias = $conexion->prepare($sqlAlias);
$stmtAlias->bind_param("s", $alias);
$stmtAlias->execute();
if ($stmtAlias->get_result()->num_rows > 0) {
    $errores[] = "El alias '$alias' ya está siendo utilizado por otro jugador.";
}

// Volvemos a revisar si hay errores después de las comprobaciones de la BDD
if (!empty($errores)) {
    echo json_encode(["status" => "error", "errores" => $errores]);
    exit;
}

// Si llegamos aquí, todo está libre. Guardamos al usuario.
$password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios 
(nombre, apellidos, telefono, alias, email, password, sexo, posicion, nivel, avatar)
VALUES 
('$nombre', '$apellidos', '$telefono', '$alias', '$email', '$password_hash', '$sexo', '$posicion', '$nivel', '$avatar_ruta')";

if ($conexion->query($sql)) {
    // Devolvemos un OK para que Javascript haga la redirección
    echo json_encode(["status" => "success", "mensaje" => "Registro completado con éxito. Redirigiendo..."]);
} else {
    // Si falla la base de datos (por ejemplo, email duplicado)
    echo json_encode(["status" => "error", "errores" => ["Error en la base de datos: " . $conexion->error]]);
}
?>