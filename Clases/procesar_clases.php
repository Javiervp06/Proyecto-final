<?php
session_start();

$nombre = $_POST["nombre"] ?? "";
$telefono = $_POST["telefono"] ?? "";
$correo = $_POST["correo"] ?? "";
$mensaje = $_POST["mensaje"] ?? "";

$errores = [];
$old = [];

/* ---------------- VALIDACIONES ---------------- */

// Nombre
if ($nombre === "") {
    $errores["nombre"] = "El nombre es obligatorio.";
} elseif (strlen($nombre) < 3 || strlen($nombre) > 20) {
    $errores["nombre"] = "El nombre debe tener entre 3 y 20 caracteres.";
}
$old["nombre"] = $nombre;

// Teléfono
if (!preg_match("/^[0-9]{9}$/", $telefono)) {
    $errores["telefono"] = "El teléfono debe tener 9 números.";
}
$old["telefono"] = $telefono;

// Correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores["correo"] = "El correo electrónico no es válido.";
}
$old["correo"] = $correo;

// Mensaje
if ($mensaje === "") {
    $errores["mensaje"] = "Los datos de interés son obligatorios.";
}
$old["mensaje"] = $mensaje;

/* ---------------- SI HAY ERRORES ---------------- */

if (!empty($errores)) {
    $_SESSION["errores"] = $errores;
    $_SESSION["old"] = $old;
    header("Location: clases.php"); // vuelve al formulario
    exit;
}

/* ---------------- SI TODO ESTÁ BIEN ---------------- */

echo "<h2>Formulario enviado correctamente</h2>";
echo "Nombre: $nombre<br>";
echo "Teléfono: $telefono<br>";
echo "Correo: $correo<br>";
echo "Mensaje: $mensaje<br>";

echo "<br><a href='clases.php'>Volver</a>";
?>
