<?php
require "../bdd/config.php";
require_once "../bdd/enviar_correo.php"; 
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $stmtUpdate = $conexion->prepare("UPDATE usuarios SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmtUpdate->bind_param("sss", $token, $expira, $email);
        $stmtUpdate->execute();

        $enlace = "http://localhost/Proyecto-final/Proyecto-final/Login/nueva_contrasena.php?token=" . $token; 
        
        $asunto = "Recuperar contraseña - PadelOrgaz";
        
        // Creamos un diseño HTML para el correo
        $cuerpo = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px;'>
            <h2 style='color: #002d57; text-align: center;'>Restablecer Contraseña</h2>
            <p style='color: #475569; font-size: 16px;'>Hola,</p>
            <p style='color: #475569; font-size: 16px;'>Has solicitado cambiar tu clave en PadelOrgaz. Haz clic en el botón de abajo para continuar:</p>
            
            <div style='text-align: center; margin: 30px 0;'>
                <a href='$enlace' style='background-color: #00a859; color: white; padding: 14px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                    Cambiar mi contraseña
                </a>
            </div>
            
            <p style='color: #94a3b8; font-size: 12px; text-align: center;'>
                Si no puedes ver el botón, copia y pega este enlace en tu navegador:<br>
                <span style='color: #0A58CA;'>$enlace</span>
            </p>
            <hr style='border: 0; border-top: 1px solid #f1f5f9; margin: 20px 0;'>
            <p style='color: #94a3b8; font-size: 12px; text-align: center;'>Si no has solicitado este cambio, puedes ignorar este correo.</p>
        </div>";

        if (mandarCorreoSMTP($email, $asunto, $cuerpo)) {
            $mensaje = "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>✅ Correo enviado. Revisa Mailtrap y pulsa el botón verde.</div>";
        } else {
            $mensaje = "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>❌ Error al enviar el correo.</div>";
        }
    } else {
        $mensaje = "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 8px; margin-bottom: 20px;'>❌ El correo no existe.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - PadelOrgaz</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="shortcut icon" href="../Imágenes/Torreorgaz.png" type="image/x-icon">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .tarjeta-recuperacion {
            background: white;
            width: 100%;
            max-width: 420px; /* Tamaño compacto */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .icono-seguridad {
            font-size: 50px;
            margin-bottom: 20px;
            display: block;
        }

        h2 {
            color: #002d57;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input[type="email"]:focus {
            border-color: #00a859;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 168, 89, 0.1);
        }

        .btn-enviar {
            width: 100%;
            background: #00a859;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 12px rgba(0, 168, 89, 0.2);
        }

        .btn-enviar:hover {
            background: #008f4c;
            transform: translateY(-1px);
        }

        .btn-enviar:active {
            transform: translateY(0);
        }

        .link-volver {
            display: inline-block;
            margin-top: 25px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .link-volver:hover {
            color: #002d57;
            text-decoration: underline;
        }

        /* Ajuste del footer para que no moleste */
        footer {
            padding: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="tarjeta-recuperacion">
            <span class="icono-seguridad">🔑</span>
            <h2>¿Has olvidado tu clave?</h2>
            <p>No te preocupes, dinos tu correo y te enviaremos un enlace para restablecerla.</p>

            <?php echo $mensaje; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="email">Tu correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
                
                <button type="submit" class="btn-enviar">Enviar instrucciones</button>
            </form>

            <a href="login.php" class="link-volver">← Volver al inicio de sesión</a>
        </div>
    </div>

    <footer>
        <p>© 2025 PadelOrgaz.</p>
    </footer>

</body>
</html>