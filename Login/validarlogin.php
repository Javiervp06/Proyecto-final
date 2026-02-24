<?php
    // 1. Comprobar que el formulario se envió por POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Acceso no permitido.");
    }

    $usuario = $_POST["username"] ?? "";
    $contrasena = $_POST["password"] ?? "";
    $errores = [];

    // Validar usuario
    if (empty($usuario)) {
        $errores[] = "El nombre de usuario es obligatorio.";
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $usuario)) {
        $errores[] = "El nombre de usuario solo puede contener letras y números.";
    } else if(strlen($usuario) < 3 || strlen($usuario) > 20) {
        $errores[] = "El nombre de usuario debe tener entre 3 y 20 caracteres.";
    }

    // Validar contraseña
    if (empty($contrasena)) {
        $errores[] = "La contraseña es obligatoria.";
    } elseif (strlen($contrasena) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    } else if (!preg_match("/[A-Z]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos una letra mayúscula.";
    } else if (!preg_match("/[a-z]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos una letra minúscula.";
    } else if (!preg_match("/[0-9]/", $contrasena)) {
        $errores[] = "La contraseña debe contener al menos un número.";
    }

    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        exit;
    }
    // 5. Si todo está bien, enviar correo
    /*$destinatario = "jvidartep05@educarex.es";
    $contenido = "
    Nombre: $nombre
    Teléfono: $telefono
    Correo: $correo
    Asunto: $asunto
    Mensaje:
    $mensaje
    ";

    $headers = "From: $correo\r\nReply-To: $correo\r\n";

    // Enviar email
    mail($destinatario, "Formulario web: $asunto", $contenido, $headers);*/
    echo "<h2>Datos recibidos:</h2>";
    echo "Usuario: $usuario<br>";
    echo "Contraseña: $contrasena<br>";

    // 6. Mensaje de éxito
    echo "<h2>Mensaje enviado correctamente</h2>";
    echo "<p>Gracias por contactar con nosotros, $usuario.</p>";
    echo "<a href='contacto.html'>Volver al inicio</a>";

?>
