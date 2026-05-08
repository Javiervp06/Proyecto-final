<?php
require "../bdd/config.php";

$token = $_GET['token'] ?? null;
$mensaje = "";
$errores = [];
$mostrar_formulario = false;

// 1. VERIFICACIÓN DEL TOKEN
if ($token) {
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $mostrar_formulario = true;
        $usuario = $resultado->fetch_assoc();
    } else {
        $mensaje = "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>❌ El enlace es inválido o ha caducado.</div>";
    }
} else {
    $mensaje = "<div style='color: #856404; background-color: #fff3cd; border: 1px solid #ffeeba; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>⚠️ Acceso denegado. Para cambiar tu clave debes usar el enlace enviado a tu correo.</div>";
}

// 2. PROCESAR EL CAMBIO DE CONTRASEÑA
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $contrasena = $_POST['password'];
    $confirmar_contrasena = $_POST['confirm_password'] ?? '';
    $user_id = $_POST['user_id'];

    // Tus validaciones exactas
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

    if (empty($errores)) {
        $nueva_pass = password_hash($contrasena, PASSWORD_DEFAULT);
        $update = $conexion->prepare("UPDATE usuarios SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $update->bind_param("si", $nueva_pass, $user_id);
        
        if ($update->execute()) {
            $mensaje = "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>✅ ¡Contraseña actualizada! <br><br> <a href='login.php' style='font-weight:bold; color:#002d57;'>Ir al Login</a></div>";
            $mostrar_formulario = false;
        }
    } else {
        $mensaje = "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align:left;'>";
        foreach ($errores as $e) { $mensaje .= "• $e<br>"; }
        $mensaje .= "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; font-family: sans-serif; }
        .card { background: white; width: 100%; max-width: 400px; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; }
        h2 { color: #002d57; margin-bottom: 25px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #4b5563; font-size: 14px; }
        input { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; background: #00a859; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Nueva Clave</h2>
        
        <?= $mensaje ?>

        <?php if ($mostrar_formulario): ?>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= $usuario['id'] ?>">
                
                <div class="form-group">
                    <label>Contraseña nueva:</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Confirmar contraseña:</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit">Guardar Cambios</button>
            </form>
        <?php else: ?>
            <a href="olvida_contrasena.php" style="color: #64748b; font-size: 14px; text-decoration: none;">← Volver a solicitar enlace</a>
        <?php endif; ?>
    </div>
</body>
</html>