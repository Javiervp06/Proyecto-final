<?php
session_start();
header('Content-Type: application/json');

// 1. CONEXIÓN A LA BASE DE DATOS
require_once "../bdd/config.php"; 

$nombre = trim($_POST["nombre"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$mensaje = trim($_POST["mensaje"] ?? "");
$errores = [];

// 2. VALIDACIONES
if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
if (!preg_match("/^[0-9]{9}$/", $telefono)) $errores[] = "El teléfono debe tener 9 números.";
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo no es válido.";
if (empty($mensaje)) $errores[] = "El mensaje es obligatorio.";

if (empty($errores)) {
    try {
        // 3. INSERCIÓN USANDO 'fecha_solicitud' Y AÑADIENDO EL 'estado'
        $sql = "INSERT INTO clases (nombre, email, telefono, mensaje, fecha_solicitud, estado) VALUES (?, ?, ?, ?, NOW(), 'Pendiente')";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $correo, $telefono, $mensaje);
            
            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success", 
                    "mensaje" => "¡Inscripción enviada correctamente!"
                ]);
            } else {
                echo json_encode([
                    "status" => "error", 
                    "errores" => ["Error al guardar: " . $conexion->error]
                ]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "errores" => ["Error de conexión."]]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "errores" => [$e->getMessage()]]);
    }
} else {
    echo json_encode(["status" => "error", "errores" => $errores]);
}
?>