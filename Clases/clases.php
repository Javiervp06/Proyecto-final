<?php
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        die("Acceso no permitido.");
    }
    $nombre = $_POST["nombre"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $correo = $_POST["correo"] ?? "";
    $mensaje = $_POST["mensaje"] ?? "";
    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    } else if (strlen($nombre) < 3 || strlen($nombre) > 20) {
        $errores[] = "El nombre debe tener entre 3 y 20 caracteres.";
    }

    if (!preg_match("/^[0-9]{9}$/", $telefono)) {
        $errores[] = "El teléfono debe tener 9 números.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio.";
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
    echo "Nombre: $nombre<br>";
    echo "Teléfono: $telefono<br>";
    echo "Correo: $correo<br>";
    echo "Mensaje: $mensaje<br>";

    // 6. Mensaje de éxito
    echo "<h2>Mensaje enviado correctamente</h2>";
    echo "<p>Gracias por contactar con nosotros, $nombre.</p>";
    echo "<a href='clases.html'>Volver al formulario de clases</a>";
?>
